<?php namespace App\Application\Services;

use App\Application\DTOs\AppointmentDto;
use App\Domain\Interfaces\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
class GetAppointmentHistoryService
{
    private AppointmentRepositoryInterface $appointmentRepository;
    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function execute(int $patientId): Collection
    {
        $appointments = $this->appointmentRepository->getHistoryByPatientId($patientId);

        return $appointments->map(function ($appointment) {
            // Format date as "Month DaySuffix, Year" e.g., "May 10th, 2023"
            $formattedDate = Carbon::parse($appointment->appointmentDate)->format('F jS, Y');

            // Format time as "HH:MM - HH:MM"
            $formattedTime = Carbon::parse($appointment->startTime)->format('H:i') .
                             ' - ' .
                             Carbon::parse($appointment->endTime)->format('H:i');

            $statusDisplay = $appointment->status;
            if ($statusDisplay === 'pending_change') {
                $statusDisplay = 'Pending';
            } else {
                $statusDisplay = ucfirst($statusDisplay);
            }

            return new AppointmentDTO(
                id: $appointment->id,
                date: $formattedDate,
                time: $formattedTime,
                reason: $appointment->reason,
                status: $statusDisplay
            );
        });
    }
 
}
