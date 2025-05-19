<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\DTOs\PrescriptionDTO;
use Carbon\Carbon;

class PrescriptionResource extends JsonResource
{
    /** @var PrescriptionDTO */
    public $resource;

    public function toArray(Request $request): array
    {
        // Déterminer le statut pour l'affichage ('active' ou 'completed')
        // basé sur le statut de la DB et les dates.
        $displayStatus = 'completed'; // Par défaut
        if ($this->resource->status === 'active') {
             if (is_null($this->resource->endDate) || $this->resource->endDate->isFuture()) {
                $displayStatus = 'active';
            }
        } else if ($this->resource->status === 'draft' || $this->resource->status === 'cancelled') {
            $displayStatus = $this->resource->status; // Ou une autre logique pour ces cas
        }


        return [
            'id' => (string)$this->resource->id,
            'type' => 'Prescription', // Correspond à MedicalRecordItem.type
            'title' => $this->resource->medicationName,
            'recordDate' => $this->resource->startDate->toIso8601String(), // Pour le tri/affichage
            'doctor' => $this->resource->doctorName,
            'summary' => $this->resource->dosage . ' - ' . $this->resource->frequency . ($this->resource->duration ? ' (' . $this->resource->duration . ')' : ''),
            'details' => $this->resource->instructions ?? 'Aucune instruction spécifique.',
            
            // Champs pour correspondre à MedicalRecordItem et au template HTML
            'tagText' => $displayStatus, // Statut pour l'affichage (active, completed, draft, cancelled)
            'tagClass' => $this->getTagClassForDisplay($displayStatus), // Classe CSS basée sur le statut d'affichage
            'status' => $displayStatus, // 'active' ou 'completed' (ou autre si besoin pour le filtre frontend)

            // Champs additionnels du DTO si le frontend en a besoin directement
            'medicationName' => $this->resource->medicationName,
            'dosage' => $this->resource->dosage,
            'frequency' => $this->resource->frequency,
            'duration' => $this->resource->duration,
            'startDate' => $this->resource->startDate->toIso8601String(),
            'endDate' => $this->resource->endDate?->toIso8601String(),
            'instructions' => $this->resource->instructions,
            'refills' => $this->resource->refills,
            'dbStatus' => $this->resource->status, // Le statut original de la base de données
        ];
    }

    private function getTagClassForDisplay(string $displayStatus): string
    {
        return match (strtolower($displayStatus)) {
            'active' => 'bg-status-success/20 text-status-success border border-status-success/30',
            'completed' => 'bg-status-neutral/20 text-status-neutral-text border border-status-neutral/30',
            'draft' => 'bg-yellow-100 text-yellow-700 border border-yellow-300', // Exemple pour draft
            'cancelled' => 'bg-red-100 text-red-700 border border-red-300',       // Exemple pour cancelled
            default => 'bg-gray-100 text-gray-700 border border-gray-300',
        };
    }
}