<?php
 

 namespace App\Repositories\Interfaces;


use App\Models\LabResult; 
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
interface LabResultRepositoryInterface
{
        /**
     * Récupère les résultats de laboratoire pour un patient donné (via son ID de Patient).
     * Les modèles LabResult retournés auront leurs relations medicalRecord et medicalRecord.doctor chargées.
     *
     * @param int $patientId L'ID du modèle Patient.
     * @return Collection<int, LabResult>
     */
    public function findByPatientId(int $patientId): Collection;

     /**
     * Récupère les résultats de laboratoire paginés pour un patient donné.
     *
     * @param int $patientId L'ID du modèle Patient.
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByPatientIdPaginated(int $patientId, int $perPage = 15): LengthAwarePaginator;


    


        /**
     * Récupère un résultat de laboratoire par son ID.
     *
     * @param int $id
     * @return LabResult|null
     */
    public function findById(int $id): ?LabResult;


        /**
     * Crée un nouveau résultat de laboratoire.
     *
     * @param array $data Les données pour créer le résultat.
     * @return LabResult
     */
    // public function create(array $data): LabResult;


 /**
     * Met à jour un résultat de laboratoire existant.
     *
     * @param int $id L'ID du résultat à mettre à jour.
     * @param array $data Les nouvelles données.
     * @return LabResult|null
     */
    // public function update(int $id, array $data): ?LabResult;


}