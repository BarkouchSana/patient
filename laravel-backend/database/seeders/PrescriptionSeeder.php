<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentPrescription;
use App\Infrastructure\Models\EloquentChartPatient;
use App\Infrastructure\Models\EloquentDoctor;
use Carbon\Carbon;
class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $chartPatient1 = EloquentChartPatient::firstOrCreate(
            ['patient_id' => 1],
            [
                'diagnosis' => 'Healthy',
                'chief_complaint' => 'Routine checkup',
                'status' => 'active', // ou un autre statut pertinent pour ChartPatient
                // Ajoutez d'autres champs nécessaires pour ChartPatient
            ]
        );
        if ($chartPatient1) {
            EloquentPrescription::create([
                'chart_patient_id' => $chartPatient1->id,
                'medication_name' => 'Amoxicilline 250mg',
                'dosage' => '1 comprimé',
                'frequency' => 'Toutes les 8 heures',
                'duration' => '7 jours',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(2), // Encore active
                'instructions' => 'Prendre avec de la nourriture.',
                'refills' => '0',
                'status' => 'active',
                'doctor_name' => 'Dr. House',
            ]);
            EloquentPrescription::create([
                'chart_patient_id' => $chartPatient1->id,
                'medication_name' => 'Paracétamol 500mg',
                'dosage' => '2 comprimés si besoin',
                'frequency' => 'Toutes les 4-6 heures',
                'duration' => 'Au besoin',
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->subDays(10), // Terminée
                'instructions' => 'Ne pas dépasser 8 comprimés par jour.',
                'refills' => '1',
                'status' => 'completed',
                'doctor_name' => 'Dr. Cuddy',
            ]);
            EloquentPrescription::create([
                'chart_patient_id' => $chartPatient1->id,
                'medication_name' => 'Vitamine D 1000 UI',
                'dosage' => '1 capsule',
                'frequency' => 'Une fois par jour',
                'duration' => '3 mois',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3), // Active, long terme
                'instructions' => 'Prendre le matin.',
                'refills' => '2',
                'status' => 'active',
                'doctor_name' => 'Dr. Wilson',
            ]);
    }
}
}