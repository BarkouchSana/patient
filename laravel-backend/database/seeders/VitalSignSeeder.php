<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VitalSign;
use App\Models\Patient;
use Carbon\Carbon;

class VitalSignSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        
        foreach ($patients as $patient) {
            // Créer plusieurs relevés de signes vitaux à différentes dates
            for ($i = 0; $i < 4; $i++) {
                $date = Carbon::now()->subDays($i * 30 + rand(1, 10));
                
                VitalSign::create([
                    'patient_id' => $patient->id,
                    'blood_pressure_systolic' => rand(110, 140),
                    'blood_pressure_diastolic' => rand(70, 90),
                    'pulse_rate' => rand(60, 100),
                    'temperature' => rand(361, 375) / 10, // 36.1 - 37.5
                    'temperature_unit' => 'Celsius',
                    'respiratory_rate' => rand(12, 20),
                    'oxygen_saturation' => rand(95, 100),
                    'weight' => rand(50, 90) + (rand(0, 9) / 10),
                    'weight_unit' => 'kg',
                    'height' => rand(150, 190),
                    'height_unit' => 'cm',
                    'notes' => $i === 0 ? 'Contrôle de routine, patient se sent bien.' : null,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }
        }
    }
}