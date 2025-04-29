<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentUser;
use App\Infrastructure\Models\EloquentPatient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users that don't have a patient record yet
        $users = EloquentUser::doesntHave('patient')->get();

        // Create a patient record for each user
        foreach ($users as $user) {
            EloquentPatient::create([
                'user_id' => $user->id,
                'registration_date' => now(),
            ]);
        }
    }
}