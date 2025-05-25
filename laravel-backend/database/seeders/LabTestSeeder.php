<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabTest;
use App\Models\ChartPatient;
use Carbon\Carbon;

class LabTestSeeder extends Seeder
{
    public function run()
    {
        $chartPatients = ChartPatient::all();
        
        $testNames = [
            'Formule Sanguine Complète (FSC)',
            'Bilan Métabolique Complet',
            'Bilan Lipidique',
            'Tests de Fonction Thyroïdienne',
            'Hémoglobine A1C',
            'Analyse d\'Urine',
            'Tests de Fonction Hépatique',
            'Bilan Rénal',
            'Test de Glycémie',
            'Niveau de Vitamine D',
            'Bilans Ferritiques',
            'Niveau de Vitamine B12',
            'Protéine C-Réactive (CRP)',
            'Vitesse de Sédimentation des Érythrocytes (VSE)',
            'Temps de Prothrombine (TP) / INR'
        ];
        
        $testCodes = [
            'FSC-001',
            'BMC-002',
            'BLP-003',
            'TFT-004',
            'A1C-005',
            'URI-006',
            'TFH-007',
            'REN-008',
            'GLU-009',
            'VITD-010',
            'FER-011',
            'VB12-012',
            'CRP-013',
            'VSE-014',
            'TP-INR-015'
        ];
        
        $urgencies = ['routine', 'urgent', 'stat'];
        
        $labNames = [
            'Laboratoire Central',
            'BioAnalyse',
            'LabExpert',
            'Diagnostics Spécialisés',
            'Laboratoire Universitaire'
        ];

        // Créer plusieurs tests de laboratoire
        foreach ($chartPatients as $chartPatient) {
            // Créer 1-3 tests pour chaque dossier patient
            $numTests = rand(1, 3);
            
            for ($i = 0; $i < $numTests; $i++) {
                $testIndex = array_rand($testNames);
                
                $requestedDate = Carbon::now()->subDays(rand(1, 60));
                $scheduledDate = Carbon::parse($requestedDate)->addDays(rand(1, 5));
                
                LabTest::create([
                    'chart_patient_id' => $chartPatient->id,
                    'test_name' => $testNames[$testIndex],
                    'test_code' => $testCodes[$testIndex],
                    'urgency' => $urgencies[array_rand($urgencies)],
                    'requested_date' => $requestedDate,
                    'scheduled_date' => $scheduledDate,
                    'lab_name' => $labNames[array_rand($labNames)],
                    'created_at' => $requestedDate,
                    'updated_at' => $requestedDate
                ]);
            }
        }
    }
}