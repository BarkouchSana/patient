<?php

namespace App\Repositories\Interfaces;


use App\Models\MedicalHistory;
interface MedicalHistoryRepositoryInterface
{
        /**
     * Récupère l'historique médical pour un patient donné.
     *
     * @param int $patientId
     * @return MedicalHistory|null
     */
    public function findByPatientId(int $patientId): ?MedicalHistory;


    //     /**
    //  * Crée ou met à jour l'historique médical pour un patient.
    //  *
    //  * @param int $patientId
    //  * @param array $data
    //  * @return MedicalHistory
    //  */
    // public function updateOrCreateByPatientId(int $patientId, array $data): MedicalHistory;

        /**
     * Crée un nouvel historique médical.
     *
     * @param array $data
     * @return MedicalHistory
     */
    // public function create(array $data): MedicalHistory;

/**
     * Met à jour un historique médical existant par son ID.
     *
     * @param int $id
     * @param array $data
     * @return MedicalHistory|null
     */
    // public function update(int $id, array $data): ?MedicalHistory;

}