<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Payment;
use App\Services\NextSMSService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $stats = [
                'total_patients' => Patient::count(),
                'total_doctors' => Doctor::count(),
                'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'total_revenue' => (float) Payment::where('status', 'paid')->sum('amount'),
                'pending_payments' => Payment::where('status', 'pending')->count(),
            ];

            $recentAppointments = Appointment::with([
                'patient',
                'doctor',
            ])
                ->whereDate('appointment_date', '>=', today()->subDays(7))
                ->orderByDesc('appointment_date')
                ->limit(8)
                ->get();

            $months = collect(range(5, 0))
                ->map(fn ($i) => Carbon::now()->startOfMonth()->subMonths($i));

            $labels = $months->map(fn (Carbon $d) => $d->format('M Y'))->values();

            $driver = DB::connection()->getDriverName();
            $ymExpr = match ($driver) {
                'sqlite' => "strftime('%Y-%m', appointment_date)",
                'pgsql' => "to_char(appointment_date, 'YYYY-MM')",
                default => "DATE_FORMAT(appointment_date, '%Y-%m')",
            };

            $appointmentsByMonthRaw = Appointment::query()
                ->selectRaw("{$ymExpr} as ym, COUNT(*) as total")
                ->where('appointment_date', '>=', Carbon::now()->startOfMonth()->subMonths(5))
                ->groupBy('ym')
                ->pluck('total', 'ym');

            $appointmentsByMonth = $months
                ->map(function (Carbon $d) use ($appointmentsByMonthRaw) {
                    $key = $d->format('Y-m');
                    return (int) ($appointmentsByMonthRaw[$key] ?? 0);
                })
                ->values();

            $orderStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            $ordersByStatusRaw = Order::query()
                ->select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            $ordersByStatus = collect($orderStatuses)
                ->map(fn ($s) => (int) ($ordersByStatusRaw[$s] ?? 0))
                ->values();

            $charts = [
                'appointments' => [
                    'labels' => $labels,
                    'data' => $appointmentsByMonth,
                ],
                'orders' => [
                    'labels' => $orderStatuses,
                    'data' => $ordersByStatus,
                ],
            ];

            return view('admin.dashboard', compact('stats', 'recentAppointments', 'charts'));
        } catch (\Exception $e) {
            \Log::error('Admin dashboard error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to load dashboard data');
        }
    }

    public function getPendingPayments()
    {
        try {
            $payments = Payment::with(['patient', 'appointment'])
                ->where('status', 'pending')
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'payments' => $payments
            ]);
        } catch (\Exception $e) {
            \Log::error('Get pending payments error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to load payments'
            ], 500);
        }
    }

    public function confirmPayment(Request $request, $paymentId)
    {
        try {
            $payment = Payment::with('patient')->find($paymentId);

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            DB::beginTransaction();

            // Update payment status
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'method' => $request->method ?? 'bank_transfer',
                'reference' => $request->reference ?? null,
            ]);

            // Send payment confirmation SMS
            if ($payment->patient->phone) {
                $smsService = new NextSMSService();
                $smsService->sendPaymentConfirmation(
                    $payment->patient->phone,
                    $payment->patient->name,
                    $payment->patient->id,
                    $payment->amount
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment confirmed successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment confirmation error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Payment confirmation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllPayments()
    {
        try {
            $payments = Payment::with(['patient', 'appointment'])
                ->latest()
                ->paginate(20);

            return view('admin.payments', compact('payments'));
        } catch (\Exception $e) {
            \Log::error('Get all payments error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to load payments');
        }
    }

    public function editPayment($paymentId)
    {
        try {
            $payment = Payment::with(['patient', 'appointment'])->find($paymentId);

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'payment' => [
                    'id'           => $payment->id,
                    'patient_name' => $payment->patient->name ?? 'N/A',
                    'patient_id'   => $payment->patient_id,
                    'amount'       => $payment->amount,
                    'service_name' => $payment->service_name ?? '',
                    'method'       => $payment->method ?? 'cash',
                    'status'       => $payment->status,
                    'reference'    => $payment->reference ?? '',
                    'paid_at'      => $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') : null,
                    'created_at'   => $payment->created_at->format('d M Y'),
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Edit payment error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to load payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePayment(Request $request, $paymentId)
    {
        try {
            $payment = Payment::find($paymentId);

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            $validated = $request->validate([
                'amount'       => 'required|numeric|min:0',
                'service_name' => 'nullable|string|max:500',
                'method'       => 'required|in:cash,bank,mobile,bank_transfer',
                'status'       => 'required|in:paid,pending,cancelled',
                'reference'    => 'nullable|string|max:500',
            ]);

            $payment->update([
                'amount'       => $validated['amount'],
                'service_name' => $validated['service_name'] ?? $payment->service_name,
                'method'       => $validated['method'],
                'status'       => $validated['status'],
                'reference'    => $validated['reference'] ?? null,
                'paid_at'      => $validated['status'] === 'paid' ? ($payment->paid_at ?? now()) : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment updated successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Update payment error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment: ' . $e->getMessage()
            ], 500);
        }
    }
}
