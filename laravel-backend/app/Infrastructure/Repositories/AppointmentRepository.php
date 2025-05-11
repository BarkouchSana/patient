<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Appointment as DomainAppointment;
use App\Domain\Interfaces\AppointmentRepositoryInterface;
use App\Infrastructure\Models\EloquentAppointment;
use Illuminate\Support\Collection;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function getHistoryByPatientId(int $patientId): Collection
    {
        return EloquentAppointment::where('patient_id', $patientId)
            ->with(['doctor', 'timeSlot']) // Eager load relationships
            ->orderBy('date', 'desc')      // Order by date, newest first
            ->get()
            ->map(function (EloquentAppointment $eloquentAppointment) {
                return new DomainAppointment(
                    id: $eloquentAppointment->id,
                    appointmentDate: $eloquentAppointment->date,
                    startTime: $eloquentAppointment->timeSlot->start_time,
                    endTime: $eloquentAppointment->timeSlot->end_time,
                    reason: $eloquentAppointment->reason, // Using 'reason' field
                    status: $eloquentAppointment->status,
                    doctorName: $eloquentAppointment->doctor ? $eloquentAppointment->doctor->name : null
                );
            });
    }
}