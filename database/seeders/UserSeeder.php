<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Admin1',
            'username' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

         User::create([
            'name' => 'Admin2',
            'username' => 'admin2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

    }
}
