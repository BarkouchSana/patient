<?php
 

namespace App\Domain\Interfaces;

use Illuminate\Support\Collection;

interface LabResultRepositoryInterface
{
    /**
     * @param int $userPatientId
     * @return Collection<int, \App\Domain\DTOs\LabResultDTO>
     */
    public function findByUserPatientId(int $userPatientId): Collection;
}