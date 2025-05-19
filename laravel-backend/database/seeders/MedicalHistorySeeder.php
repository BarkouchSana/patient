<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentMedicalHistory;
use App\Infrastructure\Models\EloquentPatient;
use Carbon\Carbon;
class MedicalHistorySeeder extends Seeder
{
    public function run(): void
    {
        $patientId = 1; 

        EloquentMedicalHistory::updateOrCreate(
            ['patient_id' => $patientId], // Find by patient_id to avoid duplicates if run multiple times
            [
                'currentMedicalConditions' => json_encode([
                    [
                        'id' => 'cmc1',
                        'conditionName' => 'Hypertension Artérielle',
                        'diagnosisDate' => '2020-05-15',
                        'treatingDoctor' => 'Dr. Cardio',
                        'notes' => 'Traitement par Lisinopril 10mg.',
                        'status' => 'Actif'
                    ],
                    [
                        'id' => 'cmc2',
                        'conditionName' => 'Asthme léger intermittent',
                        'diagnosisDate' => '2010-09-01',
                        'treatingDoctor' => 'Dr. Pulmo',
                        'notes' => 'Utilise un inhalateur de salbutamol au besoin.',
                        'status' => 'Contrôlé'
                    ]
                ]),
                'pastSurgeries' => json_encode([
                    [
                        'id' => 'surg1',
                        'surgeryName' => 'Appendicectomie',
                        'surgeryDate' => '2005-07-20',
                        'hospitalName' => 'Hôpital Central',
                        'surgeonName' => 'Dr. Chir',
                        'notes' => 'Récupération sans complications.'
                    ]
                ]),
                'chronicDiseases' => json_encode([
                    [
                        'id' => 'cd1',
                        'diseaseName' => 'Diabète de type 2',
                        'diagnosisDate' => '2018-03-10',
                        'severity' => 'Modérée', // Assuming severity is a string
                        'managementPlan' => 'Régime alimentaire, exercice, Metformine 500mg x2/jour.',
                        'notes' => 'Contrôle glycémique régulier.'
                    ]
                ]),
              'currentMedications' => json_encode([
                    [
                        'id' => 'med1',
                        'medicationName' => 'Lisinopril',
                        'dosage' => '10mg',
                        'frequency' => 'Une fois par jour',
                        'route' => 'Oral',
                        'startDate' => '2020-05-20',
                        'prescribingDoctor' => 'Dr. Cardio',
                        'purpose' => 'Hypertension'
                    ],
                    [
                        'id' => 'med2',
                        'medicationName' => 'Metformine',
                        'dosage' => '500mg',
                        'frequency' => 'Deux fois par jour',
                        'route' => 'Oral',
                        'startDate' => '2018-03-15',
                        'prescribingDoctor' => 'Dr. Endo',
                        'purpose' => 'Diabète'
                    ]
                ]),
                'allergies' => json_encode([
                    [
                        'id' => 'alg1',
                        'allergen' => 'Pénicilline',
                        'reaction' => 'Éruption cutanée, démangeaisons',
                        'severity' => 'Sévère', // Assuming severity is a string
                        'diagnosisDate' => '2000-01-15',
                        'notes' => 'Éviter tous les médicaments de la famille des pénicillines.'
                    ],
                    [
                        'id' => 'alg2',
                        'allergen' => 'Acariens',
                        'reaction' => 'Rhinite allergique, éternuements',
                        'severity' => 'Modérée',
                        'diagnosisDate' => '1995-06-01',
                        'notes' => 'Utilisation de housses anti-acariens.'
                    ]
                ]),
                'lastUpdated' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );      
    }
}
