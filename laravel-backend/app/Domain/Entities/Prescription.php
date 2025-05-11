<?php
namespace App\Domain\Entities;

class Prescription
{
    public int    $id;
    public int    $patientId;
    public int    $doctorId;
    public string $name;       // médicament
    public string $dosage;     // ex: "2 comprimés/jour"
    public string $startDate;  // YYYY-MM-DD
    public string $endDate;    // YYYY-MM-DD
    public int    $quantity;   // quantité totale
    public string $doctor;     // prescripteur
    public string $createdAt;
    public string $updatedAt;
}
