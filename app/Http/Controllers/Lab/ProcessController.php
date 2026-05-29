<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\LabRequest;
use App\Models\LabResultFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'result_files'             => 'nullable|array|max:5',
            'result_files.*'           => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
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

            // Handle file uploads
            if ($request->hasFile('result_files')) {
                foreach ($request->file('result_files') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('lab_results/' . $labRequest->id, $fileName, 'public');
                    
                    LabResultFile::create([
                        'lab_request_id' => $labRequest->id,
                        'uploaded_by' => auth()->id(),
                        'file_name' => $fileName,
                        'file_path' => $filePath,
                        'file_type' => $this->determineFileType($file),
                        'file_size' => $this->formatFileSize($file->getSize()),
                    ]);
                }
            }

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

    private function determineFileType($file)
    {
        $extension = $file->getClientOriginalExtension();
        $typeMap = [
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'pdf' => 'pdf',
        ];
        return $typeMap[$extension] ?? 'document';
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    public function downloadLabResultFile(LabResultFile $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            return response()->json(['success' => false, 'message' => 'Faili halipo.'], 404);
        }

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function deleteLabResultFile(LabResultFile $file)
    {
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'Faili limefutwa kwa mafanikio!',
        ]);
    }

    public function getLabResultFiles(LabRequest $labRequest)
    {
        $files = LabResultFile::where('lab_request_id', $labRequest->id)
            ->with('uploadedBy')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $files,
        ]);
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
