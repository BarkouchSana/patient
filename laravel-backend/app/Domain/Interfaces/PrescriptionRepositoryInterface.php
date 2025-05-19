<?php
namespace App\Domain\Interfaces;

 
use Illuminate\Support\Collection;
interface PrescriptionRepositoryInterface
{
   /**
     * Trouve les prescriptions pour un ID utilisateur (patient) donné.
     *
     * @param int $userPatientId L'ID de l'utilisateur (patient).
     * @return Collection<int, \App\Domain\DTOs\PrescriptionDTO>
     */
    public function findByUserPatientId(int $userPatientId): Collection;
}
