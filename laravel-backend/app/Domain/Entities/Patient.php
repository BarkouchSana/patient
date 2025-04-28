<?php

namespace App\Domain\Entities;

class Patient
{
    public int    $id;
    public int    $userId;
    public string $registrationDate;
    public string $createdAt;
    public string $updatedAt;
}
