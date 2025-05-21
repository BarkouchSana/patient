<?php
namespace App\DTOs;

class PatientDashboardDTO
{
    public int    $patientId;
    public string $photoUrl;
    public string $name;
    public string $surname;
    public string $birthDate;
    public string $bloodType;
    public string $emergencyContact;
    public string $bloodPressure;
    public string $lastAppointment;
    public string $nextAppointment;
    public int    $activePrescriptions;

    /** @var array<int,array{title:string,doctor:string,date:string,status:string}> */
    public array $appointments = [];

    /** @var array<int,array{name:string,dosage:string,doctor:string,startDate:string,endDate:string,quantity:int}> */
    public array $prescriptions = [];
}
