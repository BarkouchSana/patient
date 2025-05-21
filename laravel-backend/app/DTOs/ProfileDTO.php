<?php
namespace App\DTOs;

class ProfileDTO
{
    public int    $userId;
    public int    $patientId;
    public string $username;
    public string $email;
    public array  $personalInfo; // ex. ['name'=>'…','surname'=>'…',…]
}
