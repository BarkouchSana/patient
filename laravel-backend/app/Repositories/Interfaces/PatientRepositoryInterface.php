<?php

namespace App\Repositories\Interfaces;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

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

        /**
     * Récupère un patient par son ID.
     */
    public function findById(int $id): ?Patient; // Ajouté pour la cohérence

    /**
     * Récupère tous les patients.
     */
    public function getAll(): Collection; // Ajouté pour la cohérence


     /**
     * Crée un nouveau patient à partir d'un tableau de données.
     */
    // public function create(array $data): Patient;

    /**
     * Met à jour un patient existant par son ID à partir d'un tableau de données.
     */
    // public function update(int $id, array $data): ?Patient;
}
