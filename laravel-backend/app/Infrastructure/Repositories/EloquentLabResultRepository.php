<?php

namespace App\Infrastructure\Repositories;

use App\Application\DTOs\LabResultDTO;
use App\Domain\Interfaces\LabResultRepositoryInterface;
use App\Infrastructure\Models\EloquentChartPatient;
use App\Infrastructure\Models\EloquentLabResult;
use App\Infrastructure\Models\EloquentMedicalRecord;
use App\Infrastructure\Models\EloquentUser; // Assurez-vous que ce modèle User est correct
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Nécessaire pour la date par défaut dans le DTO

class EloquentLabResultRepository implements LabResultRepositoryInterface
{
    public function findByUserPatientId(int $userPatientId): Collection
    {
        Log::info("EloquentLabResultRepository: Searching lab results for user_patient_id {$userPatientId}");

        $chartPatientIds = EloquentChartPatient::where('patient_id', $userPatientId)->pluck('id');

        if ($chartPatientIds->isEmpty()) {
            Log::info("EloquentLabResultRepository: No chart_patients found for user_patient_id {$userPatientId}");
            return collect();
        }
        Log::info("EloquentLabResultRepository: Found chart_patient_ids: " . $chartPatientIds->implode(', '));

        $medicalRecords = EloquentMedicalRecord::whereIn('chart_patient_id', $chartPatientIds)->get();

        if ($medicalRecords->isEmpty()) {
            Log::info("EloquentLabResultRepository: No medical records found for chart_patient_ids.");
            return collect();
        }
        $medicalRecordIds = $medicalRecords->pluck('id');
        Log::info("EloquentLabResultRepository: Found medical_record_ids: " . $medicalRecordIds->implode(', '));

        $labResults = EloquentLabResult::whereIn('medical_record_id', $medicalRecordIds)->get();
        Log::info("EloquentLabResultRepository: Found " . $labResults->count() . " lab result models.");

        return $labResults->map(function (EloquentLabResult $labResultModel) use ($medicalRecords) {
            $medicalRecord = $medicalRecords->firstWhere('id', $labResultModel->medical_record_id);
            $doctorName = null;

            if ($medicalRecord && $medicalRecord->doctor_id) {
                $doctorUser = EloquentUser::find($medicalRecord->doctor_id);
                if ($doctorUser) {
                    $doctorName = $doctorUser->name;
                } else {
                    Log::warning("Doctor user not found for doctor_id: {$medicalRecord->doctor_id} on medical_record_id: {$medicalRecord->id}");
                }
            }

            return new LabResultDTO(
                id: $labResultModel->id,
                medicalRecordId: $labResultModel->medical_record_id,
                resultDate: $labResultModel->result_date,
                performedBy: $labResultModel->performed_by,
                testPath: $labResultModel->test_path,
                status: $labResultModel->status,
                interpretation: $labResultModel->interpretation,
                title: $medicalRecord ? $medicalRecord->title : 'N/A',
                summary: $medicalRecord ? $medicalRecord->description : 'N/A',
                doctorName: $doctorName,
                recordDate: $medicalRecord ? $medicalRecord->record_date : Carbon::now() // Fournir une date par défaut si medicalRecord est null
            );
        });
    }
}