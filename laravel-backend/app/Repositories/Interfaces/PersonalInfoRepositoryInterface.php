<?php

namespace App\Repositories\Interfaces;

use App\Models\PersonalInfo;

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


       /**
     * Crée ou met à jour les informations personnelles pour un patient.
     * Les clés du tableau $data doivent correspondre aux attributs fillable du modèle PersonalInfo.
     */
    public function updateOrCreateByPatientId(int $patientId, array $data): PersonalInfo;

    /**
     * Crée de nouvelles informations personnelles.
     * Les clés du tableau $data doivent correspondre aux attributs fillable du modèle PersonalInfo.
     */
    public function create(array $data): PersonalInfo;

    /**
     * Met à jour des informations personnelles existantes par leur ID.
     * Les clés du tableau $data doivent correspondre aux attributs fillable du modèle PersonalInfo.
     */
    public function update(int $id, array $data): ?PersonalInfo;
}
