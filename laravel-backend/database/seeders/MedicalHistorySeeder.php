<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentMedicalHistory;
use App\Infrastructure\Models\EloquentPatient;

class MedicalHistorySeeder extends Seeder
{
    public function run(): void
    {
        $patients = EloquentPatient::all();

        foreach ($patients as $patient) {
            EloquentMedicalHistory::create([
                'patient_id' => $patient->id,
                'currentMedicalConditions' => json_encode([fake()->word(), fake()->word()]),
                'pastSurgeries' => json_encode([fake()->word()]),
                'chronicDiseases' => json_encode(['Hypertension']),
                'currentMedications' => json_encode(['Paracetamol']),
                'allergies' => json_encode(['Penicillin']),
                'lastUpdated' => now(),
            ]);
        }
    }
}
