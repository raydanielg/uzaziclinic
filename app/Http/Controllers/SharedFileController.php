<?php

namespace App\Http\Controllers;

use App\Models\LabResultFile;
use App\Models\PatientFile;
use Illuminate\Support\Facades\Storage;

/**
 * Shared file download controller — accessible by any authenticated staff member.
 * Used for cross-role file sharing (receptionist ↔ doctor ↔ lab ↔ pharmacy).
 */
class SharedFileController extends Controller
{
    public function downloadPatientFile(PatientFile $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            return response()->json(['success' => false, 'message' => 'Faili halipo.'], 404);
        }
        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function downloadLabResultFile(LabResultFile $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            return response()->json(['success' => false, 'message' => 'Faili halipo.'], 404);
        }
        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function viewPatientFile(PatientFile $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'Faili halipo.');
        }
        $path = Storage::disk('public')->path($file->file_path);
        $mime = mime_content_type($path);
        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $file->file_name . '"',
        ]);
    }

    public function viewLabResultFile(LabResultFile $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'Faili halipo.');
        }
        $path = Storage::disk('public')->path($file->file_path);
        $mime = mime_content_type($path);
        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $file->file_name . '"',
        ]);
    }
}
