<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use App\Services\NextSMSService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentBookingController extends Controller
{
    public function bookAppointment(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'date_of_birth' => 'nullable|date|before:today',
                'appointment_date' => 'required|date|after:today',
                'appointment_time' => 'required|string',
                'service_type' => 'required|string',
                'reason' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            DB::beginTransaction();

            // Check if patient exists by phone
            $patient = Patient::where('phone', $request->phone)->first();

            if (!$patient) {
                // Auto-register new patient
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email ?? null,
                    'password' => Hash::make('password123'), // Default password
                    'role_id' => null, // Will be assigned customer role
                ]);

                // Assign customer role
                $customerRole = Role::where('name', 'customer')->first();
                if ($customerRole) {
                    $user->role_id = $customerRole->id;
                    $user->save();
                }

                $patient = Patient::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email ?? null,
                    'date_of_birth' => $request->date_of_birth ? Carbon::parse($request->date_of_birth) : null,
                    'address' => null,
                    'gender' => null,
                ]);
            }

            // Assign a doctor (random or based on service type)
            $doctor = Doctor::where('status', 'active')->first();
            if (!$doctor) {
                return response()->json([
                    'success' => false,
                    'message' => 'No doctors available at the moment. Please try again later.'
                ], 400);
            }

            // Create appointment
            $appointmentDateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
            
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => $appointmentDateTime,
                'status' => 'pending',
                'reason' => $request->reason ?? $request->service_type,
                'notes' => 'Booked via website - Service: ' . $request->service_type,
            ]);

            // Send SMS confirmation
            $smsService = new NextSMSService();
            $smsService->sendAppointmentConfirmation(
                $patient->phone,
                $patient->name,
                $patient->id,
                $appointment->id,
                $appointmentDateTime->format('d M Y H:i'),
                $doctor->display_name ?? 'Doctor'
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully! You will receive an SMS confirmation shortly.',
                'appointment_id' => $appointment->id,
                'patient_id' => $patient->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Front-end appointment booking error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to book appointment. Please try again or contact us directly.'
            ], 500);
        }
    }
}
