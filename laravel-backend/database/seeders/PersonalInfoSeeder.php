<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentUser;
use App\Infrastructure\Models\EloquentPatient;
use App\Infrastructure\Models\EloquentPersonalInfo;
use Illuminate\Support\Facades\Storage;

class PersonalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all patients
        $patients = EloquentPatient::all();

        foreach ($patients as $patient) {
            // Create or update personal info for each patient
            EloquentPersonalInfo::updateOrCreate(
                ['patient_id' => $patient->id],
                [
                    'name' => fake()->firstName(),
                    'surname' => fake()->lastName(),
                    'birthdate' => fake()->date('Y-m-d', '-20 years'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'address' => fake()->address(),
                    'emergency_contact' => fake()->phoneNumber(),
                    'marital_status' => fake()->randomElement(['single', 'married']),
                    'blood_type' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                    'nationality' => fake()->country(),
                    'profile_image' => null,
                ]
            );
        }

        // Create a specific profile for the test user
        $testUser = EloquentUser::where('email', 'test@example.com')->first();
        if ($testUser && $testUser->patient) {
            EloquentPersonalInfo::updateOrCreate(
                ['patient_id' => $testUser->patient->id],
                [
                    'name' => 'Test',
                    'surname' => 'User',
                    'birthdate' => '1990-01-01',
                    'gender' => 'male',
                    'address' => '123 Test Street, Test City',
                    'emergency_contact' => '123-456-7890',
                    'marital_status' => 'single',
                    'blood_type' => 'O+',
                    'nationality' => 'United States',
                    'profile_image' => null,
                ]
            );
        }
    }
}