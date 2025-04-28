<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\Patient;

interface PatientRepositoryInterface
{
    /**
     * Récupère le patient lié à un utilisateur.
     */
    public function findByUserId(int $userId): ?Patient;

    /**
     * Persiste un patient (insert ou update).
     */
    public function save(Patient $patient): Patient;
}
