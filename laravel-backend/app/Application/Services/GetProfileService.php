<?php
namespace App\Application\Services;

use App\Application\DTOs\ProfileDTO;
use App\Domain\Interfaces\PatientRepositoryInterface; // Ensure this class exists in the specified namespace
use App\Domain\Interfaces\PersonalInfoRepositoryInterface; // Ensure this class exists in the specified namespace or create it if missing
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
        $dto->personalInfo = [
            'name'             => $pi->name,
            'surname'          => $pi->surname,
            'birthdate'        => $pi->birthdate,
            'gender'           => $pi->gender,
            'address'          => $pi->address,
            'emergencyContact' => $pi->emergencyContact,
            'maritalStatus'    => $pi->maritalStatus,
            'bloodType'        => $pi->bloodType,
            'nationality'      => $pi->nationality,
            'photo'            => $pi->photo,
        ];

        return $dto;
    }
}
