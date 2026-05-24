<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\LabRequest;
use App\Models\LabTest;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * The doctor's consultation workflow.
 *
 *   /doctor/consultation                        → today's queue (patients with current_stage = with_doctor or lab_complete)
 *   /doctor/consultation/{appointment}          → consultation room (record vitals, symptoms, request lab, prescribe, complete)
 *   /doctor/consultation/{appointment}/vitals   → save vitals + chief complaint + symptoms
 *   /doctor/consultation/{appointment}/lab      → create LabRequest, set stage to AWAITING_LAB
 *   /doctor/consultation/{appointment}/prescribe → create Prescription + items, set stage to AWAITING_PHARMACY
 *   /doctor/consultation/{appointment}/complete → finalize (no pharmacy needed) → DONE
 */
class ConsultationController extends Controller
{
    private function doctorId(): ?int
    {
        return Doctor::where('user_id', auth()->id())->value('id');
    }

    /**
     * Authorize that the appointment belongs to the logged-in doctor.
     */
    private function authorizeOwnership(Appointment $appointment): void
    {
        $doctorId = $this->doctorId();
        if (!$doctorId || $appointment->doctor_id !== $doctorId) {
            abort(403, 'Unauthorized — miadi hii si yako.');
        }
    }

    /* ──────────────────────────────────────────────────────────
     * Doctor's queue — patients waiting for me right now
     * ────────────────────────────────────────────────────────── */
    public function queue()
    {
        $doctorId = $this->doctorId();

        $queue = Appointment::with(['patient.user'])
            ->forDoctor($doctorId)
            ->inQueue()
            ->orderByRaw("FIELD(current_stage, 'lab_complete', 'with_doctor')")
            ->orderBy('appointment_date')
            ->get();

        $stats = [
            'with_me'      => Appointment::forDoctor($doctorId)->atStage(Appointment::STAGE_WITH_DOCTOR)->today()->count(),
            'lab_pending'  => Appointment::forDoctor($doctorId)->atStage(Appointment::STAGE_AWAITING_LAB)->today()->count(),
            'lab_done'     => Appointment::forDoctor($doctorId)->atStage(Appointment::STAGE_LAB_COMPLETE)->today()->count(),
            'completed'    => Appointment::forDoctor($doctorId)->atStage(Appointment::STAGE_DONE)->today()->count(),
        ];

        return view('doctor.consultation.queue', compact('queue', 'stats'));
    }

    /* ──────────────────────────────────────────────────────────
     * Consultation room — single patient view
     * ────────────────────────────────────────────────────────── */
    public function show(Appointment $appointment)
    {
        $this->authorizeOwnership($appointment);

        $appointment->load([
            'patient.user',
            'labRequests' => fn ($q) => $q->latest(),
            'prescriptions.items',
        ]);

        $availableTests = LabTest::orderBy('test_name')->get();
        $medicines      = Medicine::where('quantity', '>', 0)->orderBy('name')->get();

        return view('doctor.consultation.show', compact(
            'appointment', 'availableTests', 'medicines'
        ));
    }

    /* ──────────────────────────────────────────────────────────
     * Save vitals / chief complaint / symptoms
     * ────────────────────────────────────────────────────────── */
    public function saveVitals(Request $request, Appointment $appointment)
    {
        $this->authorizeOwnership($appointment);

        $data = $request->validate([
            'chief_complaint'   => 'nullable|string|max:2000',
            'symptoms'          => 'nullable|string|max:5000',
            'vital_signs.bp'    => 'nullable|string|max:20',
            'vital_signs.pulse' => 'nullable|string|max:10',
            'vital_signs.temp'  => 'nullable|string|max:10',
            'vital_signs.spo2'  => 'nullable|string|max:10',
            'vital_signs.weight'=> 'nullable|string|max:10',
            'vital_signs.height'=> 'nullable|string|max:10',
        ]);

        $appointment->update([
            'chief_complaint' => $data['chief_complaint'] ?? $appointment->chief_complaint,
            'symptoms'        => $data['symptoms']        ?? $appointment->symptoms,
            'vital_signs'     => array_filter($data['vital_signs'] ?? []),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vitals zimehifadhiwa.',
        ]);
    }

    /* ──────────────────────────────────────────────────────────
     * Request lab tests → moves visit to AWAITING_LAB
     * ────────────────────────────────────────────────────────── */
    public function requestLab(Request $request, Appointment $appointment)
    {
        $this->authorizeOwnership($appointment);

        $data = $request->validate([
            'test_names'     => 'required|array|min:1',
            'test_names.*'   => 'required|string|max:255',
            'priority'       => 'required|in:normal,urgent,emergency',
            'clinical_notes' => 'nullable|string|max:2000',
        ]);

        try {
            DB::beginTransaction();

            $patientUserId = $appointment->patient->user_id ?? null;
            if (!$patientUserId) {
                throw new \RuntimeException('Mgonjwa hana account ya user.');
            }

            LabRequest::create([
                'appointment_id' => $appointment->id,
                'patient_id'     => $patientUserId,        // legacy schema → user_id
                'doctor_id'      => auth()->id(),          // legacy schema → user_id
                'test_names'     => implode(', ', $data['test_names']),
                'priority'       => $data['priority'],
                'clinical_notes' => $data['clinical_notes'] ?? null,
                'status'         => LabRequest::STATUS_PENDING,
            ]);

            $appointment->moveToStage(Appointment::STAGE_AWAITING_LAB);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lab request imewasilishwa. Mgonjwa anaenda lab.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindwa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* ──────────────────────────────────────────────────────────
     * Write a prescription → moves visit to AWAITING_PHARMACY
     * ────────────────────────────────────────────────────────── */
    public function prescribe(Request $request, Appointment $appointment)
    {
        $this->authorizeOwnership($appointment);

        $data = $request->validate([
            'diagnosis'             => 'required|string|max:2000',
            'notes'                 => 'nullable|string|max:2000',
            'items'                 => 'required|array|min:1',
            'items.*.medicine_id'   => 'nullable|exists:medicines,id',
            'items.*.medicine_name' => 'required|string|max:255',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.dosage'        => 'required|string|max:100',
            'items.*.frequency'     => 'required|string|max:100',
            'items.*.duration'      => 'nullable|string|max:100',
            'items.*.instructions'  => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $doctorId = $this->doctorId();

            $prescription = Prescription::create([
                'patient_id'     => $appointment->patient_id,
                'doctor_id'      => $doctorId,
                'appointment_id' => $appointment->id,
                'diagnosis'      => $data['diagnosis'],
                'notes'          => $data['notes'] ?? null,
                'status'         => Prescription::STATUS_PENDING,
            ]);

            $totalCost = 0.0;
            foreach ($data['items'] as $item) {
                $medicine  = !empty($item['medicine_id']) ? Medicine::find($item['medicine_id']) : null;
                $unitPrice = $medicine?->price ?? 0;
                $totalCost += $unitPrice * (int) $item['quantity'];

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id'     => $medicine?->id,
                    'medicine_name'   => $item['medicine_name'],
                    'quantity'        => (int) $item['quantity'],
                    'unit_price'      => $unitPrice,
                    'dosage'          => $item['dosage'],
                    'frequency'       => $item['frequency'],
                    'duration'        => $item['duration']     ?? null,
                    'instructions'    => $item['instructions'] ?? null,
                ]);
            }
            $prescription->update(['total_cost' => $totalCost]);

            // Mirror diagnosis on the appointment for quick reference
            $appointment->update([
                'diagnosis' => $data['diagnosis'],
                'notes'     => $data['notes'] ?? $appointment->notes,
            ]);

            $appointment->moveToStage(Appointment::STAGE_AWAITING_PHARMACY);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prescription imeandikwa. Mgonjwa anaenda pharmacy.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindwa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /* ──────────────────────────────────────────────────────────
     * Complete the consultation without pharmacy (e.g. counselling only)
     * ────────────────────────────────────────────────────────── */
    public function complete(Request $request, Appointment $appointment)
    {
        $this->authorizeOwnership($appointment);

        $data = $request->validate([
            'diagnosis' => 'nullable|string|max:2000',
            'notes'     => 'nullable|string|max:2000',
        ]);

        $appointment->update([
            'diagnosis' => $data['diagnosis'] ?? $appointment->diagnosis,
            'notes'     => $data['notes']     ?? $appointment->notes,
        ]);
        $appointment->moveToStage(Appointment::STAGE_DONE);

        return response()->json([
            'success' => true,
            'message' => 'Miadi imekamilika.',
        ]);
    }
}
