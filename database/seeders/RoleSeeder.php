<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'permissions' => json_encode(['all' => true])],
            ['name' => 'doctor', 'permissions' => json_encode(['view_appointments' => true, 'edit_medical_records' => true, 'prescribe' => true])],
            ['name' => 'nurse', 'permissions' => json_encode(['vitals' => true, 'update_appointment_status' => true])],
            ['name' => 'pharmacist', 'permissions' => json_encode(['manage_stock' => true, 'process_orders' => true])],
            ['name' => 'lab_tech', 'permissions' => json_encode(['record_results' => true, 'manage_inventory' => true])],
            ['name' => 'accountant', 'permissions' => json_encode(['generate_invoices' => true, 'manage_payments' => true])],
            ['name' => 'customer', 'permissions' => json_encode(['book_appointments' => true, 'buy_products' => true])],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
