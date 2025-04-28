<?php

namespace App\Domain\Entities;

class User
{
    public int     $id;
    public string  $name;
    public string  $email;
    public ?string $emailVerifiedAt;
    public string  $password;
    public ?string $phone;
    public string  $status;
    public ?string $rememberToken;
    public string  $createdAt;
    public string  $updatedAt;
}
