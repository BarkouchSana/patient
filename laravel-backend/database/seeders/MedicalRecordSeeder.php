<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\RecordType;
use App\Models\ChartPatient;
use Carbon\Carbon;

class MedicalRecordSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $recordTypes = RecordType::all();
        
        $titles = [
            'Consultation initiale',
            'Visite de suivi',
            'Révision de médication',
            'Examen de bien-être annuel',
            'Visite d\'urgence',
            'Orientation vers un spécialiste',
            'Visite de soins préventifs',
            'Contrôle post-opératoire',
            'Gestion de maladie chronique',
            'Évaluation de santé'
        ];
        
        $descriptions = [
            'Patient présentant des symptômes d\'infection respiratoire. Antibiotiques prescrits et repos conseillé.',
            'Suivi pour la gestion de l\'hypertension. Pression artérielle contrôlée avec le traitement actuel.',
            'Examen physique annuel. Tous les signes vitaux dans la plage normale. Dépistages de routine recommandés.',
            'Évaluation pour douleurs articulaires. Référé en rhumatologie pour évaluation complémentaire.',
            'Ajustement de médication pour la gestion du diabète. Niveaux d\'A1C améliorés par rapport à la visite précédente.',
            'Suivi post-chirurgical. Incision cicatrisant bien. Aucun signe d\'infection.',
            'Évaluation de la santé mentale. Le patient signale une amélioration de l\'humeur avec la thérapie actuelle.',
            'Visite de soins préventifs incluant des vaccinations et des recommandations de dépistage.',
            'Gestion des affections chroniques incluant l\'hypertension et l\'hyperlipidémie. Ajustements de médication effectués.',
            'Évaluation de douleurs abdominales aiguës. Tests diagnostiques commandés.'
        ];

        // Créer plusieurs dossiers médicaux par patient
        foreach ($patients as $patient) {
            // Obtenir tous les ChartPatient pour ce patient
            $chartPatients = ChartPatient::where('patient_id', $patient->id)->get();
            
            if ($chartPatients->isEmpty()) {
                continue;
            }
            
            // Créer 3-5 dossiers médicaux par patient
            $numRecords = rand(3, 5);
            
            for ($i = 0; $i < $numRecords; $i++) {
                $doctor = $doctors->random();
                $recordType = $recordTypes->random();
                $chartPatient = $chartPatients->random();
                
                $recordDate = Carbon::now()->subDays(rand(1, 180));
                
                $metaData = [
                    'location' => 'Hôpital Principal',
                    'department' => $doctor->specialty,
                    'visit_type' => rand(0, 1) ? 'Ambulatoire' : 'Hospitalisation'
                ];
                
                $statuses = ['draft', 'pending_review', 'final', 'amended'];
                
                MedicalRecord::create([
                    'user_id' => $patient->user_id,
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'record_type_id' => $recordType->id,
                    'title' => $titles[array_rand($titles)],
                    'description' => $descriptions[array_rand($descriptions)],
                    'metadata' => $metaData,
                    'record_date' => $recordDate,
                    'is_confidential' => rand(0, 10) === 0, // 10% de chance d'être confidentiel
                    'status' => $statuses[array_rand($statuses)],
                    'version' => '1.0',
                    'record_class_type' => 'App\\Models\\ChartPatient',
                    'record_class_id' => $chartPatient->id,
                    'chart_patient_id' => $chartPatient->id,
                    'created_at' => $recordDate,
                    'updated_at' => $recordDate
                ]);
            }
        }
    }
}