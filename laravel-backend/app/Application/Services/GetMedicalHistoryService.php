<?php

namespace App\Application\Services;

use App\Domain\Entities\MedicalHistory;
use App\Domain\Interfaces\MedicalHistoryRepositoryInterface;

class GetMedicalHistoryService
{
    private MedicalHistoryRepositoryInterface $repository;

    public function __construct(MedicalHistoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $patientId): ?MedicalHistory
    {
        return $this->repository->findByPatientId($patientId);
    }
}