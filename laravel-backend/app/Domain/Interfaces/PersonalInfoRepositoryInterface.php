<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\PersonalInfo;

interface PersonalInfoRepositoryInterface
{
    /**
     * Récupère les informations personnelles d’un patient.
     */
    public function findByPatientId(int $patientId): ?PersonalInfo;

    /**
     * Persiste les informations personnelles (insert ou update).
     */
    public function save(PersonalInfo $info): PersonalInfo;
}
