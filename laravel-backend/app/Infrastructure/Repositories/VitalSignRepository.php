<?php
 
 namespace App\Infrastructure\Repositories;

use App\Domain\Entities\VitalSignRecord;
use App\Domain\Interfaces\VitalSignRepositoryInterface; // Correction du namespace
use App\Infrastructure\Models\EloquentVitalSign;
use DateTimeImmutable;

class  VitalSignRepository implements VitalSignRepositoryInterface
{
    public function findLatestByPatientId(int $patientId): ?VitalSignRecord
    {
        $record = EloquentVitalSign::where('patient_id', $patientId)
                                  ->orderBy('created_at', 'desc') // Utiliser created_at
                                  ->first();

        if (!$record) {
            return null;
        }

        return new VitalSignRecord(
            id: $record->id,
            patientId: $record->patient_id,
            bloodPressureSystolic: $record->blood_pressure_systolic,
            bloodPressureDiastolic: $record->blood_pressure_diastolic,
            pulseRate: $record->pulse_rate,
            temperature: $record->temperature,
            temperatureUnit: $record->temperature_unit,
            respiratoryRate: $record->respiratory_rate,
            oxygenSaturation: $record->oxygen_saturation,
            weight: $record->weight,
            weightUnit: $record->weight_unit,
            height: $record->height,
            heightUnit: $record->height_unit,
            notes: $record->notes,
            recordedAt: new DateTimeImmutable($record->created_at->toDateTimeString()) // Utiliser created_at
        );
    }
}