<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Handles the patient visit lifecycle from the reception desk.
 *
 * Flow:
 *   1. Receptionist searches for an existing patient (by ID/phone/name) OR registers a new one.
 *   2. They pick a doctor & visit type, then "send to doctor" — this creates an Appointment
 *      with current_stage = WITH_DOCTOR and assigns a queue number.
 *   3. The today's queue is shown so reception can monitor where each patient is.
 */
class VisitController extends Controller
{
    /* ──────────────────────────────────────────────────────────
     * Today's Queue (main dashboard for receptionist)
     * ────────────────────────────────────────────────────────── */
    public function queue()
    {
        $today = today();

        $visits = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('appointment_date', $today)
            ->orderBy('queue_number')
            ->orderBy('appointment_date')
            ->get();

        $stats = [
            'total'             => $visits->count(),
            'with_doctor'       => $visits->where('current_stage', Appointment::STAGE_WITH_DOCTOR)->count(),
            'awaiting_lab'      => $visits->where('current_stage', Appointment::STAGE_AWAITING_LAB)->count(),
            'awaiting_pharmacy' => $visits->where('current_stage', Appointment::STAGE_AWAITING_PHARMACY)->count(),
            'completed'         => $visits->where('status', 'completed')->count(),
            'cancelled'         => $visits->where('status', 'cancelled')->count(),
        ];

        $doctors = Doctor::with('user')->where('status', 'active')->get();
        $services = \App\Models\Service::where('status', 'active')->get();

        return view('receptionist.queue', compact('visits', 'stats', 'doctors', 'services'));
    }

    /* ──────────────────────────────────────────────────────────
     * Patient lookup (by phone, patient number, or name)
     * Used by the "Find Patient" autocomplete on the queue page
     * ────────────────────────────────────────────────────────── */
    public function searchPatient(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        if (strlen($q) < 2) {
            return response()->json(['data' => []]);
        }

        // Strip "PT-" prefix if user typed a patient number (PT-001 → 1)
        $maybeId = null;
        if (preg_match('/^PT-?(\d+)$/i', $q, $m)) {
            $maybeId = (int) $m[1];
        } elseif (ctype_digit($q)) {
            $maybeId = (int) $q;
        }

        $patients = Patient::with('user')
            ->where(function ($w) use ($q, $maybeId) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%")
                                                  ->orWhere('email', 'like', "%{$q}%"));
                if ($maybeId !== null) $w->orWhere('id', $maybeId);
            })
            ->limit(15)
            ->get()
            ->map(fn ($p) => [
                'id'             => $p->id,
                'patient_number' => $p->patient_number,
                'name'           => $p->display_name,
                'phone'          => $p->phone ?? $p->user?->phone ?? '',
                'gender'         => $p->gender,
            ]);

        return response()->json(['data' => $patients]);
    }

    /* ──────────────────────────────────────────────────────────
     * Register a NEW patient (creates User + Patient profile)
     * ────────────────────────────────────────────────────────── */
    public function registerPatient(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'phone'             => 'required|string|max:20',
            'email'             => 'nullable|email|unique:users,email',
            'gender'            => 'required|in:male,female,other',
            'blood_group'       => 'nullable|string|max:5',
            'allergies'         => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $customerRoleId = Role::where('name', 'customer')->value('id');

            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'] ?? sprintf('patient_%d_%s@local.invalid', time(), substr(md5($data['phone']), 0, 6)),
                'password' => Hash::make('patient' . substr($data['phone'], -4)),
                'role_id'  => $customerRoleId,
                'status'   => 'active',
            ]);

            $patient = Patient::create([
                'user_id'           => $user->id,
                'name'              => $data['name'],
                'phone'             => $data['phone'],
                'gender'            => $data['gender'],
                'status'            => 'active',
                'blood_group'       => $data['blood_group']       ?? null,
                'allergies'         => $data['allergies']         ?? null,
                'emergency_contact' => $data['emergency_contact'] ?? null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Mgonjwa amesajiliwa: {$patient->patient_number}",
                'patient' => [
                    'id'             => $patient->id,
                    'patient_number' => $patient->patient_number,
                    'name'           => $patient->display_name,
                    'phone'          => $patient->phone,
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindwa kusajili: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* ──────────────────────────────────────────────────────────
     * Send a patient to a doctor (creates the Appointment / Visit)
     * ────────────────────────────────────────────────────────── */
    public function sendToDoctor(Request $request)
    {
        $data = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'doctor_id'       => 'required|exists:doctors,id',
            'type'            => 'nullable|string|max:100',
            'chief_complaint' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Generate today's queue number (Q001, Q002, …)
            $todayCount = Appointment::whereDate('appointment_date', today())->count();
            $queueNumber = 'Q' . str_pad((string) ($todayCount + 1), 3, '0', STR_PAD_LEFT);

            $appointment = Appointment::create([
                'patient_id'       => $data['patient_id'],
                'doctor_id'        => $data['doctor_id'],
                'appointment_date' => now(),
                'status'           => 'confirmed',
                'current_stage'    => Appointment::STAGE_WITH_DOCTOR,
                'type'             => $data['type'] ?? 'General Consultation',
                'chief_complaint'  => $data['chief_complaint'] ?? null,
                'queue_number'     => $queueNumber,
                'received_by'      => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Mgonjwa amepelekwa kwa daktari ({$queueNumber}).",
                'data'    => $appointment->load(['patient.user', 'doctor.user']),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindwa kupeleka kwa daktari: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* ──────────────────────────────────────────────────────────
     * Cancel a visit
     * ────────────────────────────────────────────────────────── */
    public function cancelVisit(Appointment $appointment)
    {
        $appointment->update([
            'status'        => 'cancelled',
            'current_stage' => $appointment->current_stage,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Miadi imefutwa.',
        ]);
    }
}
