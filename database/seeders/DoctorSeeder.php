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
                'license_number' => 'LIC-2024-001',
                'bio' => 'Experienced general physician with 10 years of practice.',
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'doctor.johnson@clinic.com',
                'phone' => '+255 713 456 789',
                'password' => Hash::make('password123'),
                'specialization' => 'Pediatrician',
                'license_number' => 'LIC-2024-002',
                'bio' => 'Specialized in pediatric care with 8 years of experience.',
            ],
            [
                'name' => 'Dr. Michael Williams',
                'email' => 'doctor.williams@clinic.com',
                'phone' => '+255 714 567 890',
                'password' => Hash::make('password123'),
                'specialization' => 'Cardiologist',
                'license_number' => 'LIC-2024-003',
                'bio' => 'Expert cardiologist with 15 years of experience in heart care.',
            ],
            [
                'name' => 'Dr. Emily Brown',
                'email' => 'doctor.brown@clinic.com',
                'phone' => '+255 715 678 901',
                'password' => Hash::make('password123'),
                'specialization' => 'Dermatologist',
                'license_number' => 'LIC-2024-004',
                'bio' => 'Dermatology specialist with 6 years of practice.',
            ],
            [
                'name' => 'Dr. David Davis',
                'email' => 'doctor.davis@clinic.com',
                'phone' => '+255 716 789 012',
                'password' => Hash::make('password123'),
                'specialization' => 'Orthopedic Surgeon',
                'license_number' => 'LIC-2024-005',
                'bio' => 'Orthopedic surgeon with 12 years of experience in bone and joint care.',
            ],
        ];

        foreach ($doctors as $doctorData) {
            // Check if user already exists
            $existingUser = User::where('email', $doctorData['email'])->first();
            
            if ($existingUser) {
                $this->command->warn("Doctor already exists: {$doctorData['name']} ({$doctorData['email']})");
                
                // Update existing user to doctor role if not already
                if ($existingUser->role_id != $doctorRole->id) {
                    $existingUser->update(['role_id' => $doctorRole->id, 'status' => 'active']);
                    $this->command->info("Updated role to doctor: {$doctorData['name']}");
                }
                
                // Check if doctor profile exists
                if (!$existingUser->doctor) {
                    Doctor::create([
                        'user_id' => $existingUser->id,
                        'specialization' => $doctorData['specialization'],
                        'license_number' => $doctorData['license_number'],
                        'bio' => $doctorData['bio'],
                    ]);
                    $this->command->info("Created doctor profile: {$doctorData['name']}");
                }
                
                continue;
            }
            
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
                'license_number' => $doctorData['license_number'],
                'bio' => $doctorData['bio'],
            ]);

            $this->command->info("Doctor created: {$doctorData['name']}");
        }

        $this->command->info('Doctors seeded successfully!');
    }
}
