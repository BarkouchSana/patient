<?php

namespace App\Services;

use App\Repositories\Interfaces\LabResultRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class GetLabResultsForPatientService
{
    protected LabResultRepositoryInterface $labResultRepository;

    public function __construct(LabResultRepositoryInterface $labResultRepository)
    {
        $this->labResultRepository = $labResultRepository;
    }

    /**
     * Exécute le service pour récupérer les résultats de laboratoire d'un patient.
     *
     * @param int $patientId L'ID du patient.
     * @return Collection Collection de modèles App\Models\LabResult.
     */
    public function execute(int $patientId): Collection
    {
        Log::info("GetLabResultsForPatientService: Executing for patient_id {$patientId}");
        return $this->labResultRepository->findByPatientId($patientId);
    }
}