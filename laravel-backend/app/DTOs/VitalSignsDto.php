<?php
 

namespace App\DTOs;

class VitalSignsDto
{
    public ?string $lastRecorded; // ISO 8601 string
    public ?VitalSignItemDto $bloodPressure;
    public ?VitalSignItemDto $pulse;
    public ?VitalSignItemDto $temperature;
    public ?VitalSignItemDto $respiratoryRate;
    public ?VitalSignItemDto $oxygenSaturation;
    public ?VitalSignItemDto $weight;
    public ?VitalSignItemDto $height;

    public function __construct(
        ?string $lastRecorded,
        ?VitalSignItemDto $bloodPressure,
        ?VitalSignItemDto $pulse,
        ?VitalSignItemDto $temperature,
        ?VitalSignItemDto $respiratoryRate,
        ?VitalSignItemDto $oxygenSaturation,
        ?VitalSignItemDto $weight,
        ?VitalSignItemDto $height
    ) {
        $this->lastRecorded = $lastRecorded;
        $this->bloodPressure = $bloodPressure;
        $this->pulse = $pulse;
        $this->temperature = $temperature;
        $this->respiratoryRate = $respiratoryRate;
        $this->oxygenSaturation = $oxygenSaturation;
        $this->weight = $weight;
        $this->height = $height;
    }
}