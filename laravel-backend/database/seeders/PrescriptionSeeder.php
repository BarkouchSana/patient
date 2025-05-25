<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prescription;
use App\Models\ChartPatient;
use App\Models\Doctor;
use Carbon\Carbon;

class PrescriptionSeeder extends Seeder
{
    public function run()
    {
        $chartPatients = ChartPatient::all();
        $doctors = Doctor::all();
        
        $medications = [
            'Lisinopril 10mg comprimé',
            'Metformine 500mg comprimé',
            'Atorvastatine 20mg comprimé',
            'Lévothyroxine 50mcg comprimé',
            'Amlodipine 5mg comprimé',
            'Oméprazole 20mg gélule',
            'Sertraline 50mg comprimé',
            'Salbutamol 100mcg inhalateur',
            'Prednisone 5mg comprimé',
            'Amoxicilline 500mg gélule',
            'Losartan 50mg comprimé',
            'Gabapentine 300mg gélule',
            'Hydrochlorothiazide 25mg comprimé',
            'Simvastatine 40mg comprimé',
            'Azithromycine 250mg comprimé'
        ];
        
        $frequencies = [
            'Une fois par jour',
            'Deux fois par jour',
            'Trois fois par jour',
            'Quatre fois par jour',
            'Toutes les 12 heures',
            'Toutes les 8 heures',
            'Toutes les 6 heures',
            'Au besoin',
            'Une fois par semaine',
            'Au coucher',
            'Avant les repas',
            'Avec les repas'
        ];
        
        $instructions = [
            'Prendre avec de la nourriture pour minimiser les troubles gastriques.',
            'Prendre à jeun, au moins 30 minutes avant de manger.',
            'Ne pas écraser ni mâcher; avaler entier.',
            'Peut causer de la somnolence; éviter de conduire ou d\'utiliser des machines.',
            'Éviter l\'alcool pendant la prise de ce médicament.',
            'Conserver à température ambiante à l\'abri de l\'humidité et de la chaleur.',
            'Prendre à la même heure chaque jour.',
            'Compléter l\'intégralité du traitement, même si les symptômes s\'améliorent.',
            'Boire beaucoup d\'eau pendant la prise de ce médicament.',
            'Éviter l\'exposition au soleil; utiliser un écran solaire et des vêtements protecteurs.'
        ];
        
        $statuses = ['active', 'completed', 'discontinued', 'pending'];

        // Créer des prescriptions pour les dossiers patients
        foreach ($chartPatients as $chartPatient) {
            // Créer 1-3 prescriptions par dossier patient
            $numPrescriptions = rand(1, 3);
            
            for ($i = 0; $i < $numPrescriptions; $i++) {
                $doctor = $doctors->random();
                
                $startDate = Carbon::now()->subDays(rand(1, 60));
                $duration = rand(7, 30); // Durée en jours
                $endDate = $startDate->copy()->addDays($duration);
                
                // Si la date de fin est passée, le statut est probablement "completed"
                $status = $endDate->isPast() ? 'completed' : $statuses[array_rand($statuses)];
                
                Prescription::create([
                    'chart_patient_id' => $chartPatient->id,
                    'medication_name' => $medications[array_rand($medications)],
                    'dosage' => rand(1, 4) * 5 . 'mg', // 5mg, 10mg, 15mg, 20mg
                    'frequency' => $frequencies[array_rand($frequencies)],
                    'duration' => $duration . ' jours',
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'instructions' => $instructions[array_rand($instructions)],
                    'refills' => rand(0, 3),
                    'status' => $status,
                    'doctor_name' => $doctor->name,
                    'created_at' => $startDate,
                    'updated_at' => $startDate
                ]);
            }
        }
    }
}