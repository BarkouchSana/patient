<?php
 

 namespace App\Repositories\Interfaces;

use App\Models\VitalSign;

interface VitalSignRepositoryInterface
{

    /**
     * Récupère le dernier enregistrement de signes vitaux pour un patient.
     */
    public function findLatestByPatientId(int $patientId): ?VitalSign;


   /**
     * Récupère un enregistrement de signes vitaux par son ID.
     */
    // public function findById(int $id): ?VitalSign;


        /**
     * Récupère tous les enregistrements de signes vitaux pour un patient, paginés.
     *
     * @param int $patientId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    // public function findByPatientIdPaginated(int $patientId, int $perPage = 15): LengthAwarePaginator;
   
    /**
     * Récupère tous les enregistrements de signes vitaux pour un patient.
     */
    // public function findAllByPatientId(int $patientId): Collection;

    /**
     * Crée un nouvel enregistrement de signes vitaux.
     */
    // public function create(array $data): VitalSign;



    /**
     * Met à jour un enregistrement de signes vitaux existant.
     */
    // public function update(int $id, array $data): ?VitalSign;

/**
     * Sauvegarde un enregistrement de signes vitaux (crée ou met à jour).
     * @deprecated Utiliser create() ou update() pour plus de clarté.
     *             Laisser pour compatibilité si des services l'utilisent encore directement.
     */
   // public function save(VitalSign $vitalSign): VitalSign;

}