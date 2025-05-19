<?php
 

namespace App\Domain\Entities;

use DateTimeImmutable;

class VitalSignRecord
{
    public int $id;
    public int $patientId;
    public ?string $bloodPressureSystolic;
    public ?string $bloodPressureDiastolic;
    public ?int $pulseRate;
    public ?float $temperature;
    public ?string $temperatureUnit;
    public ?int $respiratoryRate;
    public ?int $oxygenSaturation;
    public ?float $weight;
    public ?string $weightUnit;
    public ?float $height;
    public ?string $heightUnit;
    public ?string $notes;
    public DateTimeImmutable $recordedAt; // Utilisation de created_at comme date d'enregistrement

    public function __construct(
        int $id,
        int $patientId,
        ?string $bloodPressureSystolic,
        ?string $bloodPressureDiastolic,
        ?int $pulseRate,
        ?float $temperature,
        ?string $temperatureUnit,
        ?int $respiratoryRate,
        ?int $oxygenSaturation,
        ?float $weight,
        ?string $weightUnit,
        ?float $height,
        ?string $heightUnit,
        ?string $notes,
        DateTimeImmutable $recordedAt
    ) {
        $this->id = $id;
        $this->patientId = $patientId;
        $this->bloodPressureSystolic = $bloodPressureSystolic;
        $this->bloodPressureDiastolic = $bloodPressureDiastolic;
        $this->pulseRate = $pulseRate;
        $this->temperature = $temperature;
        $this->temperatureUnit = $temperatureUnit;
        $this->respiratoryRate = $respiratoryRate;
        $this->oxygenSaturation = $oxygenSaturation;
        $this->weight = $weight;
        $this->weightUnit = $weightUnit;
        $this->height = $height;
        $this->heightUnit = $heightUnit;
        $this->notes = $notes;
        $this->recordedAt = $recordedAt;
    }
}