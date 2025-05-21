<?php
namespace App\DTOs;

class UpdateProfileDTO
{
    public int   $userId;
    public int   $patientId;
    public array $fields;       // ex. ['name'=>'…','address'=>'…',…]
}
