<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
                // Assurez-vous que la route 'bills.pdf.download' est définie et prend 'billId'
                return route('bills.pdf.download', ['billId' => $this->id]);
                // Ou si vous stockez les PDF publiquement et avez un lien symbolique:
                // return $this->pdf_path ? Storage::url($this->pdf_path) : null;
            }, null),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),

            // Nouvelles données
            'doctor_name' => $this->whenLoaded('doctor', $this->doctor->name ?? null),
            'doctor_specialty' => $this->whenLoaded('doctor', $this->doctor->specialty ?? null),
            'payment_method' => $this->payment_method,
            'services_rendered' => BillItemResource::collection($this->whenLoaded('items')), // 'items' est le nom de la relation
        ];
    }
}