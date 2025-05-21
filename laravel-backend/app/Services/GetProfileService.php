<?php
namespace App\Services;

use App\DTOs\ProfileDTO;
use App\Repositories\Interfaces\PatientRepositoryInterface; // Ensure this class exists in the specified namespace
use App\Repositories\Interfaces\PersonalInfoRepositoryInterface; // Ensure this class exists in the specified namespace or create it if missing
use Illuminate\Support\Facades\Auth;

class GetProfileService
{
    public function __construct(
        private PatientRepositoryInterface      $patientRepo,
        private PersonalInfoRepositoryInterface $piRepo
    ) {}

    public function execute(int $userId): ?ProfileDTO
    {
        // Récupérer les infos user via la façade Auth
        $laravelUser = Auth::user(); 

                // Vérifier si l'utilisateur authentifié correspond à l'userId demandé,
        // ou si l'utilisateur authentifié a les droits pour voir ce profil.
        // Pour l'instant, on suppose que $userId est l'ID de l'utilisateur authentifié.
        if (!$laravelUser || $laravelUser->id !== $userId) {
            // Gérer le cas où l'utilisateur n'est pas trouvé ou ne correspond pas.
            // Vous pourriez lancer une exception ou retourner null selon votre logique d'application.
            return null;
        }
        $patient = $this->patientRepo->findByUserId($userId);
        if (! $patient) {
            return null;
        }

        $pi = $this->piRepo->findByPatientId($patient->id);

        $dto = new ProfileDTO();
        $dto->userId       = $userId;
        $dto->patientId    = $patient->id;
        $dto->username     = $laravelUser->name;;
        $dto->email        = $laravelUser->email;
        if ($pi) {
            // Accès direct aux attributs du modèle PersonalInfo
            // Assurez-vous que les noms d'attributs correspondent à ceux de App\Models\PersonalInfo.php (fichier #1)
            $dto->personalInfo = [
                'name' => $pi->name,
                'surname' => $pi->surname,
                // Assurez-vous que birthdate est un objet Carbon ou une chaîne formatée comme attendu par le DTO/frontend
                'birthdate' => $pi->birthdate ? ($pi->birthdate instanceof \Carbon\Carbon ? $pi->birthdate->toDateString() : $pi->birthdate) : null,
                'gender' => $pi->gender,
                'address' => $pi->address,
                'emergencyContact' => $pi->emergency_contact, // Correspond à la colonne de la DB et au modèle
                'maritalStatus' => $pi->marital_status,
                'bloodType' => $pi->blood_type,
                'nationality' => $pi->nationality,
                'photo' => $pi->profile_image, // Correspond à la colonne de la DB et au modèle
            ];
        } else {
        $dto->personalInfo = [
            'name'             => null,
            'surname'          => null,
            'birthdate'        => null,
            'gender'           => null,
            'address'          => null,
            'emergencyContact' => null,
            'maritalStatus'    => null,
            'bloodType'        => null,
            'nationality'      => null,
            'photo'            => null,
        ];
    }
        return $dto;
    }
}
