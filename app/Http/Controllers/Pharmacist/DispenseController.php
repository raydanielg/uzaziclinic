<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Pharmacist's dispensing workflow.
 *
 *   /pharmacist/dispense               → pending prescriptions queue
 *   /pharmacist/dispense/{prescription} → prescription detail (review items, deduct stock)
 *   /pharmacist/dispense/{prescription}/complete → mark dispensed, deduct stock, move visit to DONE
 */
class DispenseController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient.user', 'doctor.user', 'items.medicine', 'appointment'])
            ->pending()
            ->latest()
            ->get();

        $stats = [
            'pending'         => Prescription::pending()->count(),
            'dispensed_today' => Prescription::dispensed()->whereDate('dispensed_at', today())->count(),
            'low_stock'       => Medicine::where('quantity', '<=', 10)->count(),
        ];

        return view('pharmacist.dispense.index', compact('prescriptions', 'stats'));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient.user', 'doctor.user', 'items.medicine', 'appointment']);
        return view('pharmacist.dispense.show', compact('prescription'));
    }

    public function complete(Request $request, Prescription $prescription)
    {
        if ($prescription->status !== Prescription::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Prescription hii tayari imeshughulikiwa.',
            ], 422);
        }

        $data = $request->validate([
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|exists:prescription_items,id',
            'items.*.dispense' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $prescription->load('items.medicine');
            $totalCost = 0.0;
            $allDispensed = true;

            foreach ($data['items'] as $row) {
                $item = $prescription->items->firstWhere('id', (int) $row['id']);
                if (!$item) continue;

                if (!$row['dispense']) {
                    $allDispensed = false;
                    continue;
                }

                // Deduct stock if linked to a medicine record
                if ($item->medicine) {
                    if ($item->medicine->quantity < $item->quantity) {
                        throw new \RuntimeException(
                            "Stock haitoshi kwa {$item->medicine_name} (inahitaji {$item->quantity}, ipo {$item->medicine->quantity})."
                        );
                    }
                    $item->medicine->decrement('quantity', $item->quantity);
                }

                $item->update(['dispensed' => true]);
                $totalCost += $item->line_total;
            }

            $prescription->update([
                'status'       => Prescription::STATUS_DISPENSED,
                'dispensed_by' => auth()->id(),
                'dispensed_at' => now(),
                'total_cost'   => $totalCost,
            ]);

            // Close out the visit
            if ($prescription->appointment_id) {
                $appointment = Appointment::find($prescription->appointment_id);
                if ($appointment && $appointment->current_stage !== Appointment::STAGE_DONE) {
                    $appointment->moveToStage(Appointment::STAGE_DONE);
                }
            }

            DB::commit();

            return response()->json([
                'success'    => true,
                'message'    => $allDispensed ? 'Dawa zote zimetolewa. Miadi imekamilika.'
                                               : 'Dawa zilizochaguliwa zimetolewa.',
                'total_cost' => number_format($totalCost, 2),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Imeshindwa: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cancel(Prescription $prescription)
    {
        if ($prescription->status !== Prescription::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Hii haiwezi kufutwa tena.',
            ], 422);
        }

        $prescription->update(['status' => Prescription::STATUS_CANCELLED]);

        // Send the visit back to the doctor so they can re-prescribe / counsel
        if ($prescription->appointment_id) {
            $appointment = Appointment::find($prescription->appointment_id);
            if ($appointment && $appointment->current_stage === Appointment::STAGE_AWAITING_PHARMACY) {
                $appointment->moveToStage(Appointment::STAGE_WITH_DOCTOR);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Prescription imefutwa. Mgonjwa anarudi kwa daktari.',
        ]);
    }
}
