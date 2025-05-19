<?php

namespace App\Application\Services;

use App\Domain\Interfaces\PrescriptionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class GetPrescriptionsForPatientService
{
    private PrescriptionRepositoryInterface $prescriptionRepository;

    public function __construct(PrescriptionRepositoryInterface $prescriptionRepository)
    {
        $this->prescriptionRepository = $prescriptionRepository;
    }

    public function execute(int $userPatientId): Collection
    {
        Log::info("GetPrescriptionsForPatientService: Executing for user_patient_id {$userPatientId}");
        return $this->prescriptionRepository->findByUserPatientId($userPatientId);
    }
}