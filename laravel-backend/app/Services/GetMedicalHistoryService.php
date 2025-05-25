<?php
 

namespace App\Services;

 
use App\Repositories\Interfaces\MedicalHistoryRepositoryInterface; 
use App\Repositories\Interfaces\VitalSignRepositoryInterface;   
use App\DTOs\MedicalHistoryWithVitalsDto;
use App\DTOs\VitalSignsDto;
use App\DTOs\VitalSignItemDto;
use DateTimeInterface; 
use App\Models\VitalSign; 
class GetMedicalHistoryService
{
    private MedicalHistoryRepositoryInterface $medicalHistoryRepository;
    private VitalSignRepositoryInterface $vitalSignRepository; 

    public function __construct(
        MedicalHistoryRepositoryInterface $medicalHistoryRepository,
        VitalSignRepositoryInterface $vitalSignRepository 
    ) {
        $this->medicalHistoryRepository = $medicalHistoryRepository;
        $this->vitalSignRepository = $vitalSignRepository; 
    }

    public function execute(int $patientId): ?MedicalHistoryWithVitalsDto
    {
        $medicalHistory = $this->medicalHistoryRepository->findByPatientId($patientId);
        $latestVitalSign = $this->vitalSignRepository->findLatestByPatientId($patientId);

        if (!$medicalHistory && !$latestVitalSign) {
            return null; 
        }

        $vitalSignsDto = null;
        if ($latestVitalSign) {
            $vitalSignsDto = $this->mapVitalSignRecordToDto($latestVitalSign);
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

        // S'assurer que toutes les propriétés sont des tableaux PHP
        $currentMedicalConditions = $this->ensureArray($medicalHistory->currentMedicalConditions);
        $pastSurgeries = $this->ensureArray($medicalHistory->pastSurgeries);
        $chronicDiseases = $this->ensureArray($medicalHistory->chronicDiseases);
        $currentMedications = $this->ensureArray($medicalHistory->currentMedications);
        $allergies = $this->ensureArray($medicalHistory->allergies);

        return new MedicalHistoryWithVitalsDto(
            currentMedicalConditions: $currentMedicalConditions,
            pastSurgeries: $pastSurgeries,
            chronicDiseases: $chronicDiseases,
            currentMedications: $currentMedications,
            allergies: $allergies,
            vitalSigns: $vitalSignsDto,
            lastUpdated: $medicalHistory->lastUpdated?->format(DateTimeInterface::ATOM) // Formatage ISO 8601
        );
    }

    /**
     * S'assure qu'une valeur est un tableau.
     * Décode les chaînes JSON si nécessaire.
     */
    private function ensureArray($value): array
    {
        if (is_null($value)) {
            return [];
        }
        
        if (is_array($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }
        
        return [];
    }

    private function mapVitalSignRecordToDto(VitalSign $vitalSign): VitalSignsDto
    {
        // ... code existant inchangé ...
        return new VitalSignsDto(
            lastRecorded: $vitalSign->recorded_at ? $vitalSign->recorded_at->format(DateTimeInterface::ATOM) : null,
            bloodPressure: ($vitalSign->blood_pressure_systolic && $vitalSign->blood_pressure_diastolic)
                ? new VitalSignItemDto('Blood Pressure', $vitalSign->blood_pressure_systolic . '/' . $vitalSign->blood_pressure_diastolic, 'mmHg')
                : null,
                pulse: $vitalSign->pulse_rate
                ? new VitalSignItemDto('Pulse', (string)$vitalSign->pulse_rate, 'bpm')
                : null,
            temperature: $vitalSign->temperature
                ? new VitalSignItemDto('Temperature', (string)$vitalSign->temperature, $vitalSign->temperature_unit ?? '°C')
                : null,
            respiratoryRate: $vitalSign->respiratory_rate
                ? new VitalSignItemDto('Respiratory Rate', (string)$vitalSign->respiratory_rate, 'breaths/min')
                : null,
            oxygenSaturation: $vitalSign->oxygen_saturation
                ? new VitalSignItemDto('O₂ Saturation', (string)$vitalSign->oxygen_saturation, '%')
                : null,
            weight: $vitalSign->weight
                ? new VitalSignItemDto('Weight', (string)$vitalSign->weight, $vitalSign->weight_unit ?? 'kg')
                : null,
            height: $vitalSign->height
                ? new VitalSignItemDto('Height', (string)$vitalSign->height, $vitalSign->height_unit ?? 'cm')
                : null
        );
    }
}