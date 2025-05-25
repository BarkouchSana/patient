<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Création d'utilisateurs patients
        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+1-202-555-0153',
            'status' => 'active',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Michael Rodriguez',
            'email' => 'michael@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+1-202-555-0187',
            'status' => 'active',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Emma Thompson',
            'email' => 'emma@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+1-202-555-0192',
            'status' => 'active',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'David Chen',
            'email' => 'david@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+1-202-555-0143',
            'status' => 'active',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Olivia Martinez',
            'email' => 'olivia@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+1-202-555-0198',
            'status' => 'active',
            'email_verified_at' => now()
        ]);

        // Création d'un compte administrateur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('admin123'),
            'phone' => '+1-202-555-0001',
            'status' => 'active',
            'email_verified_at' => now()
        ]);
    }
}