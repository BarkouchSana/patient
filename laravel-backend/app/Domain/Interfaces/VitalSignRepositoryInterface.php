<?php
 

 namespace App\Domain\Interfaces;

use App\Domain\Entities\VitalSignRecord;

interface VitalSignRepositoryInterface
{
    public function findLatestByPatientId(int $patientId): ?VitalSignRecord;
}