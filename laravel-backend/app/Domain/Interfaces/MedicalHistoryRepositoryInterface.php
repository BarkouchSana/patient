<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\MedicalHistory;

interface MedicalHistoryRepositoryInterface
{
    public function findByPatientId(int $patientId): ?MedicalHistory;
}