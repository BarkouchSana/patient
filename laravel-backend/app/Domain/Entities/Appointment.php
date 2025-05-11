<?php

namespace App\Domain\Entities;
use DateTimeInterface;
class Appointment
{
    public function __construct(
        public int $id,
        public DateTimeInterface $appointmentDate,
        public string $startTime, // From TimeSlot
        public string $endTime,   // From TimeSlot
        public ?string $reason,   // From appointments.reason
        public string $status,
        public ?string $doctorName // Optional: from doctors.name if needed for context
    ) {}
}