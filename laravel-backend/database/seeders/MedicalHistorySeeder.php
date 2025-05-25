<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalHistory;
use App\Models\Patient;

class MedicalHistorySeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        
        $medicalHistoryData = [
            [
                'currentMedicalConditions' => ['Hypertension', 'Diabète de type 2', 'Asthme'],
                'pastSurgeries' => ['Appendicectomie (2010)', 'Amygdalectomie (1995)'],
                'chronicDiseases' => ['Hypertension', 'Diabète de type 2'],
                'currentMedications' => ['Lisinopril 10mg quotidien', 'Metformine 500mg deux fois par jour', 'Ventoline en cas de besoin'],
                'allergies' => ['Pénicilline', 'Fruits de mer']
            ],
            [
                'currentMedicalConditions' => ['Hypercholestérolémie', 'Arthrose'],
                'pastSurgeries' => ['Remplacement du genou (2018)', 'Réparation d\'hernie (2012)'],
                'chronicDiseases' => ['Hypercholestérolémie'],
                'currentMedications' => ['Atorvastatine 20mg quotidien', 'Paracétamol 500mg en cas de besoin', 'Supplément de glucosamine'],
                'allergies' => ['Sulfamides', 'Latex']
            ],
            [
                'currentMedicalConditions' => ['Migraine', 'Anxiété'],
                'pastSurgeries' => ['Extraction des dents de sagesse (2015)'],
                'chronicDiseases' => ['Migraine'],
                'currentMedications' => ['Sumatriptan en cas de besoin', 'Escitalopram 10mg quotidien'],
                'allergies' => ['Ibuprofène']
            ],
            [
                'currentMedicalConditions' => ['Fibrillation auriculaire', 'Maladie rénale chronique'],
                'pastSurgeries' => ['Chirurgie de la cataracte (2019)', 'Ablation de la vésicule biliaire (2005)', 'Prothèse de hanche (2017)'],
                'chronicDiseases' => ['Fibrillation auriculaire', 'Maladie rénale chronique', 'Hypertension'],
                'currentMedications' => ['Warfarine 5mg quotidien', 'Métoprolol 25mg deux fois par jour', 'Furosémide 20mg quotidien'],
                'allergies' => ['Aspirine', 'Produit de contraste']
            ],
            [
                'currentMedicalConditions' => ['Hypothyroïdie', 'Dépression', 'Reflux gastro-œsophagien'],
                'pastSurgeries' => [],
                'chronicDiseases' => ['Hypothyroïdie', 'RGO'],
                'currentMedications' => ['Lévothyroxine 50mcg quotidien', 'Sertraline 50mg quotidien', 'Oméprazole 20mg quotidien'],
                'allergies' => ['Codéine']
            ]
        ];

        foreach ($patients as $index => $patient) {
            if (isset($medicalHistoryData[$index])) {
                $historyData = $medicalHistoryData[$index];
                $historyData['patient_id'] = $patient->id;
                $historyData['lastUpdated'] = now()->subDays(rand(1, 30));
                MedicalHistory::create($historyData);
            }
        }
    }
}