<?php
 
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\DTOs\MedicalHistoryWithVitalsDto;
use App\Application\DTOs\VitalSignItemDto as AppVitalSignItemDto;

class MedicalHistoryResource extends JsonResource
{
    /**
     * La ressource sous-jacente (le DTO de réponse de l'application).
     *
     * @var MedicalHistoryWithVitalsDto
     */
    public $resource;

    private function getIconForVitalSign(string $label): string
    {
        // Normaliser le label pour la correspondance
        $normalizedLabel = strtolower(str_replace([' ', '₂'], '', $label));
        return match ($normalizedLabel) {
            'bloodpressure' => 'fas fa-heartbeat',
            'pulse' => 'fas fa-heart', // Assurez-vous que cette icône existe ou adaptez
            'temperature' => 'fas fa-thermometer-half',
            'respiratoryrate' => 'fas fa-wind', // Assurez-vous que cette icône existe ou adaptez
            'o₂saturation', 'osaturation' => 'fas fa-lungs',
            'weight' => 'fas fa-weight',
            'height' => 'fas fa-ruler-vertical', // Assurez-vous que cette icône existe ou adaptez
            default => 'fas fa-notes-medical', // Icône par défaut
        };
    }

    private function mapVitalSignItemDtoToResourceArray(?AppVitalSignItemDto $dto): ?array
    {
        if (!$dto) {
            return null;
        }
        return [
            'label' => $dto->label,
            'value' => $dto->value,
            'unit' => $dto->unit,
            'icon' => $this->getIconForVitalSign($dto->label),
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $vitalSignsResourceArray = null;
        if ($this->resource->vitalSigns) {
            $vsDto = $this->resource->vitalSigns;
            $mappedVitalSigns = [
                'bloodPressure' => $this->mapVitalSignItemDtoToResourceArray($vsDto->bloodPressure),
                'pulse' => $this->mapVitalSignItemDtoToResourceArray($vsDto->pulse),
                'temperature' => $this->mapVitalSignItemDtoToResourceArray($vsDto->temperature),
                'respiratoryRate' => $this->mapVitalSignItemDtoToResourceArray($vsDto->respiratoryRate),
                'oxygenSaturation' => $this->mapVitalSignItemDtoToResourceArray($vsDto->oxygenSaturation),
                'weight' => $this->mapVitalSignItemDtoToResourceArray($vsDto->weight),
                'height' => $this->mapVitalSignItemDtoToResourceArray($vsDto->height),
            ];

            // Filtrer les signes vitaux qui sont null après le mapping
            $filteredMappedVitalSigns = array_filter($mappedVitalSigns, fn($value) => !is_null($value));

            if (!empty($filteredMappedVitalSigns) || $vsDto->lastRecorded) {
                 $vitalSignsResourceArray = ['lastRecorded' => $vsDto->lastRecorded] + $filteredMappedVitalSigns;
            }
        }

        return [
            'currentMedicalConditions' => $this->resource->currentMedicalConditions,
            'pastSurgeries' => $this->resource->pastSurgeries,
            'chronicDiseases' => $this->resource->chronicDiseases,
            'currentMedications' => $this->resource->currentMedications,
            'allergies' => $this->resource->allergies,
            'vitalSigns' => $vitalSignsResourceArray,
            'lastUpdated' => $this->resource->lastUpdated,
        ];
    }
}