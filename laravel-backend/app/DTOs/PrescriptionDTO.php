<?php

namespace App\DTOs;

use Carbon\Carbon;

class PrescriptionDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $medicationName,
        public readonly string $dosage,
        public readonly string $frequency,
        public readonly ?string $duration,
        public readonly Carbon $startDate,
        public readonly ?Carbon $endDate,
        public readonly ?string $instructions,
        public readonly ?string $refills,
        public readonly string $status, //'active', 'completed', 'cancelled'
        public readonly ?string $doctorName
    ) {}
}