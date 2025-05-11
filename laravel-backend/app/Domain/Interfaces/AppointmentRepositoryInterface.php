<?php
namespace App\Domain\Interfaces;

use App\Domain\Entities\Appointment;
use Illuminate\Support\Collection;
interface AppointmentRepositoryInterface
{
 /**
     * Get appointment history for a specific patient.
     *
     * @param int $patientId
     * @return Collection<Appointment>
     */
    public function getHistoryByPatientId(int $patientId): Collection;
}
