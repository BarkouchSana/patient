<?php

namespace App\DTOs;

class ChangePasswordDTO
{
    public int $userId;
    public string $currentPassword;
    public string $newPassword;
    
    public function __construct(int $userId, string $currentPassword, string $newPassword)
    {
        $this->userId = $userId;
        $this->currentPassword = $currentPassword;
        $this->newPassword = $newPassword;
    }
}