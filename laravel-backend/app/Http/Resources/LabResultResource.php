<?php

namespace App\Http\Resources;

use App\DTOs\LabResultDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var LabResultDTO $this */

        $tagText = ucfirst($this->status); // Or customize based on status
        $tagClass = 'bg-status-neutral/20 text-status-neutral border border-status-neutral/30'; // Default

        switch (strtolower($this->status)) {
            case 'pending':
                $tagClass = 'bg-status-warning/20 text-status-warning border border-status-warning/30';
                break;
            case 'completed':
                $tagClass = 'bg-status-success/20 text-status-success border border-status-success/30';
                break;
            case 'reviewed':
                $tagClass = 'bg-status-info/20 text-status-info border border-status-info/30';
                break;
        }

        return [
            'id' => (string) $this->id,
            'type' => 'LabResult',
            'title' => $this->title,
            'recordDate' => $this->recordDate ? $this->recordDate->toIso8601String() : null,
            'doctor' => $this->doctorName,
            'summary' => $this->summary,
            'details' => $this->interpretation ?? 'No interpretation available.',
            'tagText' => $tagText,
            'tagClass' => $tagClass,
            'resultDate' => $this->resultDate ? $this->resultDate->toIso8601String() : null,
            'performedBy' => $this->performedBy,
            'status' => $this->status, 
        ];
    }
}