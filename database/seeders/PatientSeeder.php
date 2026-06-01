<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get customer/patient role
        $patientRole = Role::where('name', 'customer')->first();
        if (!$patientRole) {
            $patientRole = Role::create([
                'name' => 'customer',
                'permissions' => json_encode([
                    'book_own_appointments' => true,
                    'shop_pharmacy' => true,
                    'view_own_history' => true
                ])
            ]);
        }

        // List of realistic patients for Uzazi Clinic
        $patientsData = [
            [
                'name' => 'Asha Juma',
                'email' => 'asha@uzaziclinic.com',
                'phone' => '0678233736',
                'gender' => 'Female',
                'blood_group' => 'O+',
                'allergies' => 'None',
                'medical_history' => 'Pregnant (1st trimester), seeking routine prenatal care and consultations.',
                'emergency_contact' => '0712345678 (Husband - Ali Juma)',
            ],
            [
                'name' => 'Neema Mwangi',
                'email' => 'neema@uzaziclinic.com',
                'phone' => '0741064572',
                'gender' => 'Female',
                'blood_group' => 'A+',
                'allergies' => 'Penicillin',
                'medical_history' => 'Seeking long-term family planning counseling, interested in contraceptive implants.',
                'emergency_contact' => '0787654321 (Mother - Mary Mwangi)',
            ],
            [
                'name' => 'Zuhura Ramadhani',
                'email' => 'zuhura@uzaziclinic.com',
                'phone' => '0767825843',
                'gender' => 'Female',
                'blood_group' => 'B-',
                'allergies' => 'Sulfa drugs',
                'medical_history' => 'Postnatal checkup (6 weeks postpartum). Normal delivery with no complications.',
                'emergency_contact' => '0654321987 (Husband - Ramadhani S.)',
            ],
            [
                'name' => 'Fatma Kassim',
                'email' => 'fatma@uzaziclinic.com',
                'phone' => '0712344321',
                'gender' => 'Female',
                'blood_group' => 'AB+',
                'allergies' => 'None',
                'medical_history' => 'Reproductive health education, counseling, and nutritional support.',
                'emergency_contact' => '0711223344 (Sister - Halima Kassim)',
            ],
            [
                'name' => 'Joyce Lazaro',
                'email' => 'joyce@uzaziclinic.com',
                'phone' => '0688998877',
                'gender' => 'Female',
                'blood_group' => 'O-',
                'allergies' => 'None',
                'medical_history' => 'Routine pregnancy follow-up (3rd trimester, 34 weeks). Experiencing mild back pain.',
                'emergency_contact' => '0788776655 (Husband - Lazaro M.)',
            ],
            [
                'name' => 'Grace Mwakipale',
                'email' => 'grace@uzaziclinic.com',
                'phone' => '0755443322',
                'gender' => 'Female',
                'blood_group' => 'A-',
                'allergies' => 'Dust, Latex',
                'medical_history' => 'Infertility assessment, couple counseling, and ovarian tracking.',
                'emergency_contact' => '0622334455 (Brother - John Mwakipale)',
            ],
            [
                'name' => 'Emmanuel Charles',
                'email' => 'emmanuel@uzaziclinic.com',
                'phone' => '0744112233',
                'gender' => 'Male',
                'blood_group' => 'O+',
                'allergies' => 'None',
                'medical_history' => 'Couple family planning checkup & preconception wellness consultation.',
                'emergency_contact' => '0744112234 (Wife - Irene Charles)',
            ],
            [
                'name' => 'Mariam Shaban',
                'email' => 'mariam@uzaziclinic.com',
                'phone' => '0677556633',
                'gender' => 'Female',
                'blood_group' => 'B+',
                'allergies' => 'Aspirin',
                'medical_history' => 'Pregnancy checkup (2nd trimester, 20 weeks). Seeking maternal counseling.',
                'emergency_contact' => '0677556634 (Mother - Khadija Shaban)',
            ],
            [
                'name' => 'Khadija Omary',
                'email' => 'khadija@uzaziclinic.com',
                'phone' => '0762112233',
                'gender' => 'Female',
                'blood_group' => 'A+',
                'allergies' => 'None',
                'medical_history' => 'Follow-up on contraceptive method (IUD placement checkup). No complaints.',
                'emergency_contact' => '0762112234 (Husband - Omary S.)',
            ],
            [
                'name' => 'Rachel Michael',
                'email' => 'rachel@uzaziclinic.com',
                'phone' => '0655443322',
                'gender' => 'Female',
                'blood_group' => 'O+',
                'allergies' => 'None',
                'medical_history' => 'Menstrual health counseling, pelvic pain assessment, and ultrasound review.',
                'emergency_contact' => '0655443323 (Sister - Sarah Michael)',
            ],
        ];

        foreach ($patientsData as $data) {
            // Check if User already exists
            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make('password'),
                    'role_id' => $patientRole->id,
                    'status' => 'active',
                ]);
            }

            // Create Patient record
            Patient::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'gender' => $data['gender'],
                    'blood_group' => $data['blood_group'],
                    'allergies' => $data['allergies'],
                    'medical_history' => $data['medical_history'],
                    'emergency_contact' => $data['emergency_contact'],
                    'status' => 'active',
                ]
            );
        }

        // Also check if 'patient@afyacare.com' (Jane Patient from AdminSeeder) exists and lacks a Patient card
        $jane = User::where('email', 'patient@afyacare.com')->first();
        if ($jane) {
            Patient::updateOrCreate(
                ['user_id' => $jane->id],
                [
                    'name' => 'Jane Patient',
                    'phone' => '0712345679',
                    'gender' => 'Female',
                    'blood_group' => 'O+',
                    'allergies' => 'None',
                    'medical_history' => 'Default seed patient record. Seeking general consultation.',
                    'emergency_contact' => '0712345670 (Spouse)',
                    'status' => 'active',
                ]
            );
        }
    }
}
