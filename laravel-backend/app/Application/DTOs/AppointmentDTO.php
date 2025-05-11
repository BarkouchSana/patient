<?php
namespace App\Application\DTOs;

class AppointmentDTO
{
    public function __construct(
        public int $id,
        public string $date, // Formatted e.g., "May 10th, 2023"
        public string $time, // Formatted e.g., "09:00 - 09:30"
        public ?string $reason,
        public string $status
    ) {}
}
