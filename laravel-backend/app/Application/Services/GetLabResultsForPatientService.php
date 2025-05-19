<?php

namespace App\Application\Services;

use App\Domain\Interfaces\LabResultRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class GetLabResultsForPatientService
{
    protected LabResultRepositoryInterface $labResultRepository;

    public function __construct(LabResultRepositoryInterface $labResultRepository)
    {
        $this->labResultRepository = $labResultRepository;
    }

    public function execute(int $userPatientId): Collection
    {
        Log::info("GetLabResultsForPatientService: Executing for user_patient_id {$userPatientId}");
        return $this->labResultRepository->findByUserPatientId($userPatientId);
    }
}