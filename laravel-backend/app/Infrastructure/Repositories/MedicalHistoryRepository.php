<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\MedicalHistory;
use App\Domain\Interfaces\MedicalHistoryRepositoryInterface;
use App\Infrastructure\Models\EloquentMedicalHistory;
use Carbon\Carbon;
use DateTimeImmutable;
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
            $record->currentMedicalConditions ?? [], // Assurer que c'est un tableau
            $record->pastSurgeries ?? [],
            $record->chronicDiseases ?? [],
            $record->currentMedications ?? [],
            $record->allergies ?? [],
            $record->lastUpdated ? new DateTimeImmutable($record->lastUpdated->toDateTimeString()) : null // Modifié
        );
    }
}