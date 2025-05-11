<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentPrescription;
use App\Infrastructure\Models\EloquentPatient;
use App\Infrastructure\Models\EloquentDoctor;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $patients = EloquentPatient::all();
        $doctors = EloquentDoctor::all();

        foreach ($patients as $patient) {
            EloquentPrescription::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctors->random()->id ?? null,
                'medication_name' => fake()->word(),
                'dosage' => fake()->randomElement(['1 tablet/day', '2 tablets/day', '1 injection/week']),
                'quantity' => fake()->numberBetween(5, 30),
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(10),
            ]);
        }
    }
}
