<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\MedicalHistory;
use App\Domain\Interfaces\MedicalHistoryRepositoryInterface;
use App\Infrastructure\Models\EloquentMedicalHistory;

class MedicalHistoryRepository implements MedicalHistoryRepositoryInterface
{
    public function findByPatientId(int $patientId): ?MedicalHistory
    {
        $record = EloquentMedicalHistory::where('patient_id', $patientId)->first();

        if (!$record) {
            return null;
        }

        return new MedicalHistory(
            $record->id,
            $record->patient_id,
            $record->currentMedicalConditions,
            $record->pastSurgeries,
            $record->chronicDiseases,
            $record->currentMedications,
            $record->allergies,
            $record->lastUpdated
        );
    }
}