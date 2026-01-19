<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'admin@bakery.com'],
            [
                'name' => 'System Admin',
                'username' => 'superadmin',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
                'status' => 'active',
            ]
        );
    }
}
