<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define all roles with their specific permissions
        $roles = [
            [
                'name' => 'admin',
                'permissions' => json_encode([
                    'all_access' => true,
                    'manage_users' => true,
                    'manage_settings' => true,
                    'view_reports' => true
                ])
            ],
            [
                'name' => 'doctor',
                'permissions' => json_encode([
                    'view_appointments' => true,
                    'manage_patients' => true,
                    'add_prescriptions' => true,
                    'lab_requests' => true,
                    'view_medical_records' => true
                ])
            ],
            [
                'name' => 'nurse',
                'permissions' => json_encode([
                    'patient_checkin' => true,
                    'vitals_recording' => true,
                    'ward_management' => true,
                    'medication_administration' => true
                ])
            ],
            [
                'name' => 'pharmacist',
                'permissions' => json_encode([
                    'manage_stock' => true,
                    'process_prescriptions' => true,
                    'manage_suppliers' => true,
                    'pharmacy_reports' => true
                ])
            ],
            [
                'name' => 'lab_tech',
                'permissions' => json_encode([
                    'manage_tests' => true,
                    'enter_results' => true,
                    'manage_equipment' => true,
                    'lab_reports' => true
                ])
            ],
            [
                'name' => 'accountant',
                'permissions' => json_encode([
                    'create_invoices' => true,
                    'manage_payments' => true,
                    'insurance_claims' => true,
                    'financial_reports' => true
                ])
            ],
            [
                'name' => 'receptionist',
                'permissions' => json_encode([
                    'register_patients' => true,
                    'book_appointments' => true,
                    'queue_management' => true,
                    'basic_billing' => true
                ])
            ],
            [
                'name' => 'customer',
                'permissions' => json_encode([
                    'book_own_appointments' => true,
                    'shop_pharmacy' => true,
                    'view_own_history' => true
                ])
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['name' => $roleData['name']], $roleData);
        }

        // Create specific users for each role for testing
        $adminRole = Role::where('name', 'admin')->first();
        $doctorRole = Role::where('name', 'doctor')->first();
        $nurseRole = Role::where('name', 'nurse')->first();
        $pharmacistRole = Role::where('name', 'pharmacist')->first();
        $labTechRole = Role::where('name', 'lab_tech')->first();
        $accountantRole = Role::where('name', 'accountant')->first();
        $receptionistRole = Role::where('name', 'receptionist')->first();
        $patientRole = Role::where('name', 'customer')->first();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'status' => 'active'
            ],
            [
                'name' => 'Dr. John Doe',
                'email' => 'doctor@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $doctorRole->id,
                'status' => 'active'
            ],
            [
                'name' => 'Nurse Mary',
                'email' => 'nurse@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $nurseRole->id,
                'status' => 'active'
            ],
            [
                'name' => 'Pharmacist Mike',
                'email' => 'pharmacist@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $pharmacistRole->id,
                'status' => 'active'
            ],
            [
                'name' => 'Lab Tech Sam',
                'email' => 'lab@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $labTechRole->id,
                'status' => 'active'
            ],
            [
                'name' => 'Accountant Sarah',
                'email' => 'accountant@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $accountantRole->id,
                'status' => 'active'
            ],
            [
                'name' => 'Receptionist Alice',
                'email' => 'receptionist@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $receptionistRole->id,
                'status' => 'active'
            ],
            [
                'name' => 'Jane Patient',
                'email' => 'patient@afyacare.com',
                'password' => Hash::make('password'),
                'role_id' => $patientRole->id,
                'status' => 'active'
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
