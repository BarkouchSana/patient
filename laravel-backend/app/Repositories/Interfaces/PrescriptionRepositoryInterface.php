<?php
namespace App\Repositories\Interfaces;

use App\Models\Prescription;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
interface PrescriptionRepositoryInterface
{
    /**
     * Trouve les prescriptions pour un ID de patient donné.
     *
     * @param int $patientId L'ID du modèle Patient.
     * @return Collection<int, Prescription>
     */
    public function findByPatientId(int $patientId): Collection;

    /**
     * Trouve les prescriptions paginées pour un ID de patient donné.
     *
     * @param int $patientId L'ID du modèle Patient.
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByPatientIdPaginated(int $patientId, int $perPage = 15): LengthAwarePaginator;

    //  /**
    //  * Crée une nouvelle prescription.
    //  */
    // public function create(array $data): Prescription;

    // /**
    //  * Récupère une prescription par son ID.
    //  */
    // public function findById(int $id): ?Prescription;

    // /**
    //  * Met à jour une prescription existante.
    //  */
    // public function update(int $id, array $data): ?Prescription;
}
