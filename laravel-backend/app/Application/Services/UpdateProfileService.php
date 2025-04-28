<?php
namespace App\Application\Services;

use App\Application\DTOs\UpdateProfileDTO;
use App\Domain\Interfaces\PersonalInfoRepositoryInterface;

class UpdateProfileService
{
    public function __construct(
        private PersonalInfoRepositoryInterface $piRepo
    ) {}

    public function execute(UpdateProfileDTO $dto): void
    {
        $pi = $this->piRepo->findByPatientId($dto->patientId);
        if (!$pi) {
            throw new \Exception("Personal info not found for patient ID: {$dto->patientId}");
        }
        foreach ($dto->fields as $key => $value) {
            if (property_exists($pi, $key)) {
                $pi->$key = $value;
            }
        }
        $this->piRepo->save($pi);
    }
}
