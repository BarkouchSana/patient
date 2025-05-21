<?php
 

 namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface MedicalRecordRepositoryInterface
{
    // ... autres méthodes ...

    /**
     * Trouve les enregistrements de résultats de laboratoire pour un patient utilisateur donné.
     * @param int $userPatientId
     * @return Collection<int, \App\Domain\DTOs\LabResultViewDTO>
     */
    public function findLabResultsForUserPatient(int $userPatientId): Collection;
}