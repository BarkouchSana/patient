<?php
namespace App\Domain\Interfaces;

use App\Domain\Entities\Prescription;

interface PrescriptionRepositoryInterface
{
    /** @return Prescription[] */
    public function findActiveByPatientId(int $patientId): array;
}
