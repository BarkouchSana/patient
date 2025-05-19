<?php
 
namespace App\Application\DTOs;

class MedicalHistoryWithVitalsDto
{
    public array $currentMedicalConditions;
    public array $pastSurgeries;
    public array $chronicDiseases;
    public array $currentMedications;
    public array $allergies;
    public ?VitalSignsDto $vitalSigns;
    public ?string $lastUpdated; // ISO 8601 string

    public function __construct(
        array $currentMedicalConditions,
        array $pastSurgeries,
        array $chronicDiseases,
        array $currentMedications,
        array $allergies,
        ?VitalSignsDto $vitalSigns,
        ?string $lastUpdated
    ) {
        $this->currentMedicalConditions = $currentMedicalConditions;
        $this->pastSurgeries = $pastSurgeries;
        $this->chronicDiseases = $chronicDiseases;
        $this->currentMedications = $currentMedications;
        $this->allergies = $allergies;
        $this->vitalSigns = $vitalSigns;
        $this->lastUpdated = $lastUpdated;
    }
}