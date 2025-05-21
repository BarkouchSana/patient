<?php

namespace App\DTOs;

use Carbon\Carbon;

class LabResultDTO
{
    public function __construct(
        public readonly int $id, // LabResult ID
        public readonly int $medicalRecordId,
        public readonly Carbon $resultDate,
        public readonly ?string $performedBy,
        public readonly ?string $testPath,
        public readonly string $status,
        public readonly ?string $interpretation,
        public readonly string $title, // From MedicalRecord
        public readonly string $summary, // From MedicalRecord
        public readonly ?string $doctorName, // From MedicalRecord
        public readonly Carbon $recordDate // From MedicalRecord    ) {}
    ){}
    }