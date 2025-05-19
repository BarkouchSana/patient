<?php

namespace App\Infrastructure\Repositories;

use App\Application\DTOs\PrescriptionDTO;
use App\Domain\Interfaces\PrescriptionRepositoryInterface;
use App\Infrastructure\Models\EloquentChartPatient;
use App\Infrastructure\Models\EloquentPrescription;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
 
 
 

class PrescriptionRepository implements PrescriptionRepositoryInterface
{
    public function findByUserPatientId(int $userPatientId): Collection
    {
        Log::info("EloquentPrescriptionRepository: Searching prescriptions for user_patient_id {$userPatientId}");

        $chartPatientIds = EloquentChartPatient::where('patient_id', $userPatientId)->pluck('id');

        if ($chartPatientIds->isEmpty()) {
            Log::info("EloquentPrescriptionRepository: No chart_patients found for user_patient_id {$userPatientId}");
            return collect();
        }

        Log::info("EloquentPrescriptionRepository: Found chart_patient_ids: " . $chartPatientIds->implode(', '));

        $prescriptions = EloquentPrescription::whereIn('chart_patient_id', $chartPatientIds)
            ->orderBy('start_date', 'desc')
            ->get();

        Log::info("EloquentPrescriptionRepository: Found " . $prescriptions->count() . " prescriptions models.");

        return $prescriptions->map(function (EloquentPrescription $prescriptionModel) {
            // Le statut du DTO sera le statut de la DB. La logique de 'active'/'completed' pour l'affichage
            // sera gérée par le frontend ou la ressource si nécessaire pour le tag.
            return new PrescriptionDTO(
                id: $prescriptionModel->id,
                medicationName: $prescriptionModel->medication_name,
                dosage: $prescriptionModel->dosage,
                frequency: $prescriptionModel->frequency,
                duration: $prescriptionModel->duration,
                startDate: $prescriptionModel->start_date, // Déjà un objet Carbon grâce au cast du modèle
                endDate: $prescriptionModel->end_date,   // Déjà un objet Carbon ou null grâce au cast
                instructions: $prescriptionModel->instructions,
                refills: $prescriptionModel->refills,
                status: $prescriptionModel->status, // Statut direct de la DB
                doctorName: $prescriptionModel->doctor_name
            );
        });
    }
}