<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Récupère un utilisateur par son identifiant.
     */
    public function findById(int $id): ?User;

    /**
     * Récupère un utilisateur par son email.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Persiste un utilisateur (insert ou update).
     */
    public function save(User $user): User;
}
