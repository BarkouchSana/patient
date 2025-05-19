<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Infrastructure\Models\EloquentUser; // Assurez-vous que le namespace est correct pour votre modèle User
use App\Infrastructure\Models\EloquentPatient;
use App\Infrastructure\Models\EloquentPersonalInfo;
use App\Infrastructure\Models\EloquentDoctor;
use App\Infrastructure\Models\EloquentChartPatient;
use App\Infrastructure\Models\EloquentRecordType;
use App\Infrastructure\Models\EloquentMedicalRecord;
use App\Infrastructure\Models\EloquentLabResult;
class LabTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
  
 
            $chartPatient = EloquentChartPatient::firstOrCreate(
                ['patient_id' => 1, 'chief_complaint' => 'Routine Checkup with Lab Work'],
                [
                    'diagnosis' => 'Pending Lab Results',
                    'status' => 'active',
                    'followup_date' => Carbon::now()->addWeeks(2),
                    //'doctor_id' => $doctor->id, // Assurez-vous que votre table chart_patients a doctor_id
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
            $labResultRecordType = EloquentRecordType::firstOrCreate(
                ['name' => 'Lab Result'],
                [
                    'code' => 'LAB_RESULT', // Ajoutez une valeur pour le code ici
                    'description' => 'Represents results from laboratory tests.',
                    // Les autres champs comme metadata_schema, requires_attachment, is_active
                    // ont soit ->nullable() soit ->default() dans la migration,
                    // donc ils n'ont pas besoin d'être spécifiés ici si les valeurs par défaut conviennent.
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
            $medicalRecordLab = EloquentMedicalRecord::create([
                'user_id' => 1, // Qui a créé/possède ce dossier (peut être le patient ou un admin/docteur)
                'patient_id' => 1, // L'ID de l'utilisateur patient
                'doctor_id' => 1,
                'record_type_id' => $labResultRecordType->id,
                'title' => 'Complete Blood Count (CBC)',
                'description' => 'Routine blood test results.',
                'metadata' => json_encode(['test_code' => 'CBC001', 'panel_name' => 'Hematology Panel']),
                'record_date' => Carbon::now()->subDay(),
                'is_confidential' => false,
                'status' => 'completed', // Statut du dossier médical lui-même
                'version' => 1,
                'chart_patient_id' => $chartPatient->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            EloquentLabResult::create([
                'medical_record_id' => $medicalRecordLab->id,
                'result_date' => Carbon::now()->subHours(12),
                'performed_by' => 'Central Lab Services',
                'test_path' => null, // ou '/path/to/lab_result_cbc.pdf'
                'status' => 'completed', // Statut du résultat de labo: 'pending', 'completed', 'reviewed'
                'interpretation' => 'All values within normal range. White blood cell count: 7.5, Red blood cell count: 4.8, Hemoglobin: 14.2,...',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $medicalRecordLipid = EloquentMedicalRecord::create([
                'user_id' => 1,
                'patient_id' => 1,
                'doctor_id' => 1,
                'record_type_id' => $labResultRecordType->id,
                'title' => 'Lipid Panel',
                'description' => 'Cholesterol and triglyceride levels.',
                'metadata' => json_encode(['test_code' => 'LIPID001']),
                'record_date' => Carbon::now()->subDays(2),
                'is_confidential' => false,
                'status' => 'reviewed',
                'version' => 1,
                'chart_patient_id' => $chartPatient->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            EloquentLabResult::create([
                'medical_record_id' => $medicalRecordLipid->id,
                'result_date' => Carbon::now()->subDays(1)->subHours(5),
                'performed_by' => 'Advanced Diagnostics Lab',
                'test_path' => null,
                'status' => 'reviewed',
                'interpretation' => 'Total Cholesterol: 185 mg/dL, HDL: 55 mg/dL, LDL: 110 mg/dL, Triglycerides: 100 mg/dL. Overall good lipid profile.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $this->command->info('Lab test data seeded successfully!');
        });     
    }
}
