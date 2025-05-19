<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'amount' => (float) $this->amount,
            'issue_date' => $this->issue_date->format('Y-m-d'),
            'due_date' => $this->due_date->format('Y-m-d'),
            'status' => $this->status,
            'notes' => $this->notes,
            'pdf_link' => $this->when($this->pdf_path, function () {
                // Génère un lien vers la route de téléchargement du PDF
                return route('bills.pdf.download', ['billId' => $this->id]);
                // Ou si vous stockez les PDF publiquement et avez un lien symbolique:
                // return $this->pdf_path ? Storage::url($this->pdf_path) : null;
            }),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}