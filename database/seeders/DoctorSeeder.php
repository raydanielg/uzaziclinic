<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get doctor role
        $doctorRole = Role::where('name', 'doctor')->first();
        
        if (!$doctorRole) {
            $this->command->error('Doctor role not found. Please run RoleSeeder first.');
            return;
        }

        // Create doctors
        $doctors = [
            [
                'name' => 'Dr. John Smith',
                'email' => 'doctor.smith@clinic.com',
                'phone' => '+255 712 345 678',
                'password' => Hash::make('password123'),
                'specialization' => 'General Physician',
                'qualification' => 'MBBS, MD',
                'experience' => 10,
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'doctor.johnson@clinic.com',
                'phone' => '+255 713 456 789',
                'password' => Hash::make('password123'),
                'specialization' => 'Pediatrician',
                'qualification' => 'MBBS, DCH',
                'experience' => 8,
            ],
            [
                'name' => 'Dr. Michael Williams',
                'email' => 'doctor.williams@clinic.com',
                'phone' => '+255 714 567 890',
                'password' => Hash::make('password123'),
                'specialization' => 'Cardiologist',
                'qualification' => 'MBBS, MD, DM',
                'experience' => 15,
            ],
            [
                'name' => 'Dr. Emily Brown',
                'email' => 'doctor.brown@clinic.com',
                'phone' => '+255 715 678 901',
                'password' => Hash::make('password123'),
                'specialization' => 'Dermatologist',
                'qualification' => 'MBBS, MD',
                'experience' => 6,
            ],
            [
                'name' => 'Dr. David Davis',
                'email' => 'doctor.davis@clinic.com',
                'phone' => '+255 716 789 012',
                'password' => Hash::make('password123'),
                'specialization' => 'Orthopedic Surgeon',
                'qualification' => 'MBBS, MS',
                'experience' => 12,
            ],
        ];

        foreach ($doctors as $doctorData) {
            // Create user
            $user = User::create([
                'name' => $doctorData['name'],
                'email' => $doctorData['email'],
                'phone' => $doctorData['phone'],
                'password' => $doctorData['password'],
                'role_id' => $doctorRole->id,
                'status' => 'active',
            ]);

            // Create doctor profile
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $doctorData['specialization'],
                'qualification' => $doctorData['qualification'],
                'experience' => $doctorData['experience'],
                'consultation_fee' => 5000,
            ]);

            $this->command->info("Doctor created: {$doctorData['name']}");
        }

        $this->command->info('Doctors seeded successfully!');
    }
}
