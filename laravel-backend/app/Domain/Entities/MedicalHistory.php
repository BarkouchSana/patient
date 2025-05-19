<?php

namespace App\Domain\Entities;
use DateTimeImmutable;
class MedicalHistory
{
    public int $id;
    public int $patientId;
    public array $currentMedicalConditions;
    public array $pastSurgeries;
    public array $chronicDiseases;
    public array $currentMedications;
    public array $allergies;
    public ?DateTimeImmutable $lastUpdated;

    public function __construct(
        int $id,
        int $patientId,
        array $currentMedicalConditions,
        array $pastSurgeries,
        array $chronicDiseases,
        array $currentMedications,
        array $allergies,
        ?DateTimeImmutable $lastUpdated
    ) {
        $this->id = $id;
        $this->patientId = $patientId;
        $this->currentMedicalConditions = $currentMedicalConditions;
        $this->pastSurgeries = $pastSurgeries;
        $this->chronicDiseases = $chronicDiseases;
        $this->currentMedications = $currentMedications;
        $this->allergies = $allergies;
        $this->lastUpdated = $lastUpdated;
    }
}