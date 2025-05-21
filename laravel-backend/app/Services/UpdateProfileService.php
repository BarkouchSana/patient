<?php
namespace App\Application\Services;

use App\DTOs\UpdateProfileDTO;
use App\Models\PersonalInfo;
use App\Repositories\Interfaces\PersonalInfoRepositoryInterface;
use Illuminate\Support\Facades\Log;
class UpdateProfileService
{
    public function __construct(
        private PersonalInfoRepositoryInterface $piRepo
    ) {}


        /**
     * Met à jour ou crée les informations personnelles pour un patient.
     *
     * @param UpdateProfileDTO $dto Les données pour la mise à jour.
     * @return PersonalInfo Le modèle PersonalInfo mis à jour ou créé.
     * @throws \RuntimeException Si la mise à jour ou la création échoue.
     */
    public function execute(UpdateProfileDTO $dto): PersonalInfo
    {
      Log::info("UpdateProfileService: Updating/creating personal info for patient ID {$dto->patientId}", ['fields' => $dto->fields]);

      $personalInfo = $this->piRepo->updateOrCreateByPatientId($dto->patientId, $dto->fields);

      if (!$personalInfo) {
          // Cette situation ne devrait normalement pas se produire avec updateOrCreateByPatientId,
          // car il est censé créer l'enregistrement s'il n'existe pas et retourner le modèle.
          // Si null est retourné, cela pourrait indiquer un problème dans l'implémentation du repository
          // ou une condition d'échec inattendue.
          Log::error("UpdateProfileService: Failed to update or create personal info for patient ID: {$dto->patientId}");
          throw new \RuntimeException("Failed to update or create personal info for patient ID: {$dto->patientId}");
      }

      Log::info("UpdateProfileService: Successfully updated/created personal info for patient ID {$dto->patientId}, ID: {$personalInfo->id}");
      return $personalInfo;
    
    }
}
