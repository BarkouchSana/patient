<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartPatient;
use App\Models\Patient;
use Carbon\Carbon;

class ChartPatientSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        
        $diagnoses = [
            'Hypertension essentielle',
            'Diabète de type 2 sans complications',
            'Trouble dépressif majeur, récurrent, en rémission partielle',
            'Reflux gastro-œsophagien sans œsophagite',
            'Trouble anxieux généralisé',
            'Hypercholestérolémie',
            'Arthrose du genou',
            'Infection aiguë des voies respiratoires supérieures',
            'Carence en vitamine D',
            'Anémie ferriprive',
            'Bronchite aiguë',
            'Rhinite allergique',
            'Lombalgie chronique',
            'Migraine sans aura'
        ];
        
        $complaints = [
            'Douleur thoracique',
            'Essoufflement',
            'Maux de tête',
            'Douleur abdominale',
            'Douleur articulaire',
            'Fatigue',
            'Vertiges',
            'Nausées et vomissements',
            'Fièvre',
            'Toux',
            'Mal de gorge',
            'Éruption cutanée',
            'Perte de poids',
            'Insomnie',
            'Douleur lombaire'
        ];
        
        $statuses = ['active', 'resolved', 'pending', 'in progress'];

        // Créer 2-3 dossiers par patient
        foreach ($patients as $patient) {
            $numCharts = rand(2, 3);
            
            for ($i = 0; $i < $numCharts; $i++) {
                $createdDate = Carbon::now()->subDays(rand(1, 365));
                $followupDate = $i === 0 
                    ? Carbon::now()->addDays(rand(7, 30)) 
                    : $createdDate->copy()->addDays(rand(14, 60));
                
                $status = $i === 0 ? 'active' : $statuses[array_rand($statuses)];
                
                ChartPatient::create([
                    'patient_id' => $patient->id,
                    'diagnosis' => $diagnoses[array_rand($diagnoses)],
                    'chief_complaint' => $complaints[array_rand($complaints)],
                    'status' => $status,
                    'followup_date' => $followupDate,
                    'created_at' => $createdDate,
                    'updated_at' => $createdDate
                ]);
            }
        }
    }
}