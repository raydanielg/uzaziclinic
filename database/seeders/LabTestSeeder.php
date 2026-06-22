<?php

namespace Database\Seeders;

use App\Models\LabTest;
use Illuminate\Database\Seeder;

class LabTestSeeder extends Seeder
{
    public function run()
    {
        $tests = [
            ['name' => 'Complete Blood Count (CBC)', 'category' => 'Hematology', 'sample_type' => 'Blood', 'price' => 15000, 'turnaround_time' => '2 hours', 'status' => 'active'],
            ['name' => 'Blood Group & Rh Factor', 'category' => 'Hematology', 'sample_type' => 'Blood', 'price' => 8000, 'turnaround_time' => '1 hour', 'status' => 'active'],
            ['name' => 'Hemoglobin (Hb)', 'category' => 'Hematology', 'sample_type' => 'Blood', 'price' => 5000, 'turnaround_time' => '1 hour', 'status' => 'active'],
            ['name' => 'Malaria Parasite (MP)', 'category' => 'Parasitology', 'sample_type' => 'Blood', 'price' => 10000, 'turnaround_time' => '30 mins', 'status' => 'active'],
            ['name' => 'Widal Test (Typhoid)', 'category' => 'Serology', 'sample_type' => 'Blood', 'price' => 12000, 'turnaround_time' => '2 hours', 'status' => 'active'],
            ['name' => 'Blood Sugar (FBS/RBS)', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 7000, 'turnaround_time' => '1 hour', 'status' => 'active'],
            ['name' => 'Liver Function Test (LFT)', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 25000, 'turnaround_time' => '4 hours', 'status' => 'active'],
            ['name' => 'Kidney Function Test (KFT)', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 25000, 'turnaround_time' => '4 hours', 'status' => 'active'],
            ['name' => 'Lipid Profile', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 20000, 'turnaround_time' => '4 hours', 'status' => 'active'],
            ['name' => 'HIV Test (Rapid)', 'category' => 'Serology', 'sample_type' => 'Blood', 'price' => 10000, 'turnaround_time' => '30 mins', 'status' => 'active'],
            ['name' => 'Hepatitis B (HBsAg)', 'category' => 'Serology', 'sample_type' => 'Blood', 'price' => 15000, 'turnaround_time' => '2 hours', 'status' => 'active'],
            ['name' => 'Urinalysis', 'category' => 'Urinalysis', 'sample_type' => 'Urine', 'price' => 8000, 'turnaround_time' => '1 hour', 'status' => 'active'],
            ['name' => 'Urine Culture', 'category' => 'Microbiology', 'sample_type' => 'Urine', 'price' => 15000, 'turnaround_time' => '48 hours', 'status' => 'active'],
            ['name' => 'Stool Culture', 'category' => 'Microbiology', 'sample_type' => 'Stool', 'price' => 15000, 'turnaround_time' => '48 hours', 'status' => 'active'],
            ['name' => 'Stool Microscopy', 'category' => 'Parasitology', 'sample_type' => 'Stool', 'price' => 8000, 'turnaround_time' => '2 hours', 'status' => 'active'],
            ['name' => 'Sputum AFB (TB Test)', 'category' => 'Microbiology', 'sample_type' => 'Sputum', 'price' => 10000, 'turnaround_time' => '24 hours', 'status' => 'active'],
            ['name' => 'Pregnancy Test (HCG)', 'category' => 'Serology', 'sample_type' => 'Urine', 'price' => 6000, 'turnaround_time' => '30 mins', 'status' => 'active'],
            ['name' => 'Throat Swab Culture', 'category' => 'Microbiology', 'sample_type' => 'Swab', 'price' => 12000, 'turnaround_time' => '48 hours', 'status' => 'active'],
        ];

        foreach ($tests as $test) {
            LabTest::updateOrCreate(
                ['name' => $test['name']],
                array_merge($test, ['test_name' => $test['name']])
            );
        }

        $this->command->info('Lab tests seeded successfully!');
    }
}
