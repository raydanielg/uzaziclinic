<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Doctor Consultation',
                'description' => 'General consultation with a doctor',
                'price' => 700000,
                'status' => 'active',
            ],
            [
                'name' => 'Laboratory Tests',
                'description' => 'Basic laboratory tests and analysis',
                'price' => 150000,
                'status' => 'active',
            ],
            [
                'name' => 'Medication',
                'description' => 'Prescribed medication and pharmacy services',
                'price' => 250000,
                'status' => 'active',
            ],
            [
                'name' => 'Vaccination',
                'description' => 'Vaccination services',
                'price' => 50000,
                'status' => 'active',
            ],
            [
                'name' => 'Maternal Care',
                'description' => 'Prenatal and postnatal care services',
                'price' => 300000,
                'status' => 'active',
            ],
            [
                'name' => 'Emergency Services',
                'description' => 'Emergency medical care',
                'price' => 500000,
                'status' => 'active',
            ],
            [
                'name' => 'X-Ray',
                'description' => 'X-ray imaging services',
                'price' => 200000,
                'status' => 'active',
            ],
            [
                'name' => 'Ultrasound',
                'description' => 'Ultrasound imaging services',
                'price' => 300000,
                'status' => 'active',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
            $this->command->info("Service created: {$service['name']} - TZS {$service['price']}");
        }

        $this->command->info('Services seeded successfully!');
    }
}
