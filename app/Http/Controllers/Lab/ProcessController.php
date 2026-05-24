<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\LabRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Lab technician's request-processing workflow.
 *
 *   /lab/process               → today's open lab requests
 *   /lab/process/{labRequest}  → request detail page (enter results)
 *   /lab/process/{labRequest}/start    → mark processing
 *   /lab/process/{labRequest}/complete → save results, mark complete, move appointment to LAB_COMPLETE
 */
class ProcessController extends Controller
{
    public function index()
    {
        $requests = LabRequest::with(['patient', 'doctor', 'appointment.patient.user'])
            ->open()
            ->orderByRaw("FIELD(priority, 'emergency', 'urgent', 'normal')")
            ->latest()
            ->get();

        $stats = [
            'pending'    => LabRequest::pending()->count(),
            'processing' => LabRequest::processing()->count(),
            'completed_today' => LabRequest::completed()->whereDate('completed_at', today())->count(),
            'urgent'     => LabRequest::open()->whereIn('priority', ['urgent', 'emergency'])->count(),
        ];

        return view('lab.process.index', compact('requests', 'stats'));
    }

    public function show(LabRequest $labRequest)
    {
        $labRequest->load(['patient', 'doctor', 'appointment.patient.user']);
        return view('lab.process.show', compact('labRequest'));
    }

    public function start(LabRequest $labRequest)
    {
        if ($labRequest->status !== LabRequest::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Request hii tayari imeanzishwa au kukamilishwa.',
            ], 422);
        }

        $labRequest->update([
            'status'              => LabRequest::STATUS_PROCESSING,
            'technician_id'       => auth()->id(),
            'sample_collected_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Imeanza kuchakatwa. Sample imekusanywa.',
        ]);
    }

    public function complete(Request $request, LabRequest $labRequest)
    {
        $data = $request->validate([
            'results'                  => 'required|array|min:1',
            'results.*.test_name'      => 'required|string|max:255',
            'results.*.value'          => 'required|string|max:100',
            'results.*.unit'           => 'nullable|string|max:50',
            'results.*.normal_range'   => 'nullable|string|max:100',
            'results.*.flag'           => 'nullable|in:normal,low,high,critical',
            'result_notes'             => 'nullable|string|max:5000',
        ]);

        try {
            DB::beginTransaction();

            $labRequest->update([
                'status'        => LabRequest::STATUS_COMPLETED,
                'technician_id' => $labRequest->technician_id ?: auth()->id(),
                'result_data'   => $data['results'],
                'result_notes'  => $data['result_notes'] ?? null,
                'completed_at'  => now(),
            ]);

            // Move the linked visit back to the doctor for review
            if ($labRequest->appointment_id) {
                $appointment = Appointment::find($labRequest->appointment_id);
                if ($appointment && $appointment->current_stage === Appointment::STAGE_AWAITING_LAB) {
                    $appointment->moveToStage(Appointment::STAGE_LAB_COMPLETE);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Matokeo yamehifadhiwa. Mgonjwa anarudi kwa daktari.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindwa: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cancel(LabRequest $labRequest)
    {
        $labRequest->update(['status' => LabRequest::STATUS_CANCELLED]);

        // If the visit was waiting on this lab, send it back to the doctor
        if ($labRequest->appointment_id) {
            $appointment = Appointment::find($labRequest->appointment_id);
            if ($appointment && $appointment->current_stage === Appointment::STAGE_AWAITING_LAB) {
                $appointment->moveToStage(Appointment::STAGE_WITH_DOCTOR);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Lab request imefutwa.',
        ]);
    }
}
