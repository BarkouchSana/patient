<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if test user exists before creating it
        $testUser = User::where('email', 'test@example.com')->first();
        
        if (!$testUser) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Call our custom seeders in the right order
        $this->call([
            PatientSeeder::class,
            PersonalInfoSeeder::class,
        ]);
    }
}
