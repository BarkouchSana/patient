<?php
namespace App\Application\Services;

use App\Application\DTOs\PatientDashboardDTO;
use App\Domain\Interfaces\PatientRepositoryInterface;
use App\Domain\Interfaces\AppointmentRepositoryInterface;
use App\Domain\Interfaces\PrescriptionRepositoryInterface;
use App\Domain\Interfaces\PersonalInfoRepositoryInterface;
use DateTime;

class GetPatientDashboardService
{
    public function __construct(
        private PatientRepositoryInterface       $patientRepo,
        private AppointmentRepositoryInterface   $apptRepo,
        private PrescriptionRepositoryInterface  $prescRepo,
        private PersonalInfoRepositoryInterface   $infoRepo
    ) {}

    public function execute(int $userId): ?PatientDashboardDTO
    {
    //     // Récupère le patient via userId
    //     $patient = $this->patientRepo->findByUserId($userId);
    //     if (! $patient) {
    //         return null;
    //     }

    //     // Récupère les infos perso
    //     $info = $this->infoRepo->findByPatientId($patient->id);
    //     if (! $info) {
    //         return null;
    //     }

    //     $dto = new PatientDashboardDTO();
    //     $dto->patientId = $patient->id;
    //     $dto->photoUrl = $info->photo ?? '';
    //     $dto->name = $info->name;
    //     $dto->surname = $info->surname;
    //     $dto->birthDate = $info->birthdate;
    //     $dto->bloodType = $info->bloodType ?? '';
    //     $dto->emergencyContact = $info->emergencyContact ?? '';
    //     $dto->bloodPressure = '120/80'; // Static value for now


    //     $appointments = $this->apptRepo->findByPatientId($patient->id);
    //     $today = new DateTime();

    //     $pastAppointments = array_filter($appointments, fn($a) => new DateTime($a->date) < $today);
    //     $futureAppointments = array_filter($appointments, fn($a) => new DateTime($a->date) >= $today);

    //     usort($pastAppointments, fn($a, $b) => strcmp($a->date, $b->date));
    //     usort($futureAppointments, fn($a, $b) => strcmp($a->date, $b->date));

    //     $dto->lastAppointment = $pastAppointments ? end($pastAppointments)->date : '';
    //     $dto->nextAppointment = $futureAppointments ? reset($futureAppointments)->date : '';

    //     $dto->appointments = array_map(fn($a) => [
    //         'title' => $a->title,
    //         'doctor' => $a->doctor,
    //         'date' => $a->date,
    //         'status' => $a->status,
    //     ], $appointments);

    //     $prescriptions = $this->prescRepo->findActiveByPatientId($patient->id);
    //     $dto->activePrescriptions = count($prescriptions);
    //     $dto->prescriptions = array_map(fn($p) => [
    //         'name' => $p->name,
    //         'dosage' => $p->dosage,
    //         'doctor' => $p->doctor,
    //         'startDate' => $p->startDate,
    //         'endDate' => $p->endDate,
    //         'quantity' => $p->quantity,
    //     ], $prescriptions);
        

    //     // tension en dur ou depuis un champ blood_pressure
    //     // $dto->bloodPressure = '120/80'; 

    //     return $dto;
    // }
}
