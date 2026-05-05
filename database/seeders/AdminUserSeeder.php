<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@afyacare.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole ? $adminRole->id : null,
            'status' => 'active',
        ]);
    }
}
