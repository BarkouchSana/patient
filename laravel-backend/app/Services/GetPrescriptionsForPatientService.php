<?php

namespace App\Services;

use App\Repositories\Interfaces\PrescriptionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\DTOs\PrescriptionDTO;
class GetPrescriptionsForPatientService
{
    private PrescriptionRepositoryInterface $prescriptionRepository;

    public function __construct(PrescriptionRepositoryInterface $prescriptionRepository)
    {
        $this->prescriptionRepository = $prescriptionRepository;
    }

    /**
     * Exécute le service pour récupérer les prescriptions d'un patient.
     *
     * @param int $patientId L'ID du patient.
     * @return Collection Collection de modèles App\Models\Prescription.
     */
    public function execute(int $patientId): Collection
    {
        $models = $this->prescriptionRepository->findByPatientId($patientId);

        return $models->map(function ($model) {
            return new PrescriptionDTO(
                id: $model->id,
                medicationName: $model->medication_name,
                dosage: $model->dosage,
                frequency: $model->frequency,
                duration: $model->duration,
                startDate: $model->start_date,
                endDate: $model->end_date,
                instructions: $model->instructions,
                refills: $model->refills,
                status: $model->status,
                doctorName: $model->doctor_name,
            );
        });    }
}