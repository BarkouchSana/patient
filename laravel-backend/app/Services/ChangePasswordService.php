<?php

namespace App\Services;

use App\DTOs\ChangePasswordDTO;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ChangePasswordService
{
    /**
     * Change le mot de passe d'un utilisateur.
     *
     * @param ChangePasswordDTO $dto Les données pour le changement de mot de passe.
     * @return bool Indique si le changement de mot de passe a réussi.
     */
    public function execute(ChangePasswordDTO $dto): bool
    {
        Log::info("ChangePasswordService: Changing password for user ID {$dto->userId} ");

        $user = User::find($dto->userId);
        
        if (!$user) {
            Log::error("ChangePasswordService: User not found with ID: {$dto->userId}");
            return false;
        }
        
           // S'assurer que l'utilisateur est bien associé à un patient
        $patient = Patient::where('user_id', $user->id)->first();
        if (!$patient) {
            Log::error("ChangePasswordService: No patient record found for user ID: {$dto->userId}");
            return false;
        }
        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($dto->currentPassword, $user->password)) {
            Log::error("ChangePasswordService: Current password is incorrect for user ID: {$dto->userId}");
            return false;
        }
        
        // Mettre à jour le mot de passe
        $user->password = Hash::make($dto->newPassword);
        $user->save();
        
        Log::info("ChangePasswordService: Password successfully changed for user ID: {$dto->userId}");
        return true;
    }
}