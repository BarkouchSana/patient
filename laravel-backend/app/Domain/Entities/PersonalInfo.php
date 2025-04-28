<?php

namespace App\Domain\Entities;
//modèle métier
class PersonalInfo
{
    public int     $id;
    public int     $patientId;
    public string  $name;
    public string  $surname;
    public string  $birthdate;
    public ?string $gender;
    public ?string $address;
    public ?string $emergencyContact;
    public ?string $maritalStatus;
    public ?string $bloodType;
    public ?string $nationality;
    public ?string $photo;
    public string  $createdAt;
    public string  $updatedAt;
}
