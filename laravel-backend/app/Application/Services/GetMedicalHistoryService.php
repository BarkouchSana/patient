<?php

// namespace App\Application\Services;

// use App\Domain\Entities\MedicalHistory;
// use App\Domain\Interfaces\MedicalHistoryRepositoryInterface;

// class GetMedicalHistoryService
// {
//     private MedicalHistoryRepositoryInterface $repository;

//     public function __construct(MedicalHistoryRepositoryInterface $repository)
//     {
//         $this->repository = $repository;
//     }

//     public function execute(int $patientId): ?MedicalHistory
//     {
//         return $this->repository->findByPatientId($patientId);
//     }
// }


 
namespace App\Application\Services;

use App\Domain\Entities\MedicalHistory as DomainMedicalHistory;
use App\Domain\Entities\VitalSignRecord as DomainVitalSignRecord;
use App\Domain\Interfaces\MedicalHistoryRepositoryInterface; // Correction du namespace
use App\Domain\Interfaces\VitalSignRepositoryInterface;   // Ajouté
use App\Application\DTOs\MedicalHistoryWithVitalsDto;
use App\Application\DTOs\VitalSignsDto;
use App\Application\DTOs\VitalSignItemDto;
use DateTimeInterface; // Ajouté

class GetMedicalHistoryService
{
    private MedicalHistoryRepositoryInterface $medicalHistoryRepository;
    private VitalSignRepositoryInterface $vitalSignRepository; // Ajouté

    public function __construct(
        MedicalHistoryRepositoryInterface $medicalHistoryRepository,
        VitalSignRepositoryInterface $vitalSignRepository // Ajouté
    ) {
        $this->medicalHistoryRepository = $medicalHistoryRepository;
        $this->vitalSignRepository = $vitalSignRepository; // Ajouté
    }

    public function execute(int $patientId): ?MedicalHistoryWithVitalsDto
    {
        $medicalHistory = $this->medicalHistoryRepository->findByPatientId($patientId);
        $latestVitalSignRecord = $this->vitalSignRepository->findLatestByPatientId($patientId);

        if (!$medicalHistory && !$latestVitalSignRecord) {
            return null; // Aucune information disponible
        }

        $vitalSignsDto = null;
        if ($latestVitalSignRecord) {
            $vitalSignsDto = $this->mapVitalSignRecordToDto($latestVitalSignRecord);
        }

        if (!$medicalHistory) {
            // Si l'historique n'existe pas, mais qu'on a des signes vitaux,
            // on retourne un DTO avec des champs d'historique vides.
            return new MedicalHistoryWithVitalsDto(
                currentMedicalConditions: [],
                pastSurgeries: [],
                chronicDiseases: [],
                currentMedications: [],
                allergies: [],
                vitalSigns: $vitalSignsDto,
                lastUpdated: null
            );
        }

        return new MedicalHistoryWithVitalsDto(
            currentMedicalConditions: $medicalHistory->currentMedicalConditions,
            pastSurgeries: $medicalHistory->pastSurgeries,
            chronicDiseases: $medicalHistory->chronicDiseases,
            currentMedications: $medicalHistory->currentMedications,
            allergies: $medicalHistory->allergies,
            vitalSigns: $vitalSignsDto,
            lastUpdated: $medicalHistory->lastUpdated?->format(DateTimeInterface::ATOM) // Formatage ISO 8601
        );
    }

    private function mapVitalSignRecordToDto(DomainVitalSignRecord $record): VitalSignsDto
    {
        return new VitalSignsDto(
            lastRecorded: $record->recordedAt->format(DateTimeInterface::ATOM),
            bloodPressure: ($record->bloodPressureSystolic && $record->bloodPressureDiastolic)
                ? new VitalSignItemDto('Blood Pressure', $record->bloodPressureSystolic . '/' . $record->bloodPressureDiastolic, 'mmHg')
                : null,
            pulse: $record->pulseRate
                ? new VitalSignItemDto('Pulse', (string)$record->pulseRate, 'bpm')
                : null,
            temperature: $record->temperature
                ? new VitalSignItemDto('Temperature', (string)$record->temperature, $record->temperatureUnit ?? '°C')
                : null,
            respiratoryRate: $record->respiratoryRate
                ? new VitalSignItemDto('Respiratory Rate', (string)$record->respiratoryRate, 'breaths/min')
                : null,
            oxygenSaturation: $record->oxygenSaturation
                ? new VitalSignItemDto('O₂ Saturation', (string)$record->oxygenSaturation, '%')
                : null,
            weight: $record->weight
                ? new VitalSignItemDto('Weight', (string)$record->weight, $record->weightUnit ?? 'kg')
                : null,
            height: $record->height
                ? new VitalSignItemDto('Height', (string)$record->height, $record->heightUnit ?? 'cm')
                : null
        );
    }
}