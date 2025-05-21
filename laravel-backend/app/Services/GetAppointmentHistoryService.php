<?php 

namespace App\Services;

use App\DTOs\AppointmentDto;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
class GetAppointmentHistoryService
{
    private AppointmentRepositoryInterface $appointmentRepository;
    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function execute(int $patientId): Collection
    {
        Log::info("GetAppointmentHistoryService: Executing for patient_id {$patientId}");
        $appointments = $this->appointmentRepository->getHistoryByPatientId($patientId);
        Log::info("GetAppointmentHistoryService: Found {$appointments->count()} appointments for patient_id {$patientId}");
        return $appointments->map(function (Appointment $appointment) {
            // Format date as "Month DaySuffix, Year" e.g., "May 10th, 2023"
            $formattedDate = Carbon::parse($appointment->date)->format('F jS, Y');

            // Format time as "HH:MM - HH:MM"
            $formattedTime = 'N/A'; // Valeur par défaut si timeSlot n'est pas disponible
            if ($appointment->timeSlot) {
                $formattedTime = Carbon::parse($appointment->timeSlot->start_time)->format('H:i') .
                             ' - ' .
                             Carbon::parse($appointment->timeSlot->end_time)->format('H:i');
                            }
        $statusDisplay = $appointment->status;
        if ($statusDisplay === 'pending_change') {
            $statusDisplay = 'Pending';
        } elseif ($statusDisplay === 'scheduled') {
            $statusDisplay = 'Confirmed';
        } else {
            $statusDisplay = ucfirst($statusDisplay);
        }
 // Récupérer le nom du médecin directement depuis le modèle Doctor
 $doctorName = $appointment->doctor ? $appointment->doctor->name : 'N/A';
 $doctorSpecialty = $appointment->doctor ? $appointment->doctor->specialty : null;
           
             // Générer la localisation (exemple)
             $location = 'Medical Center, Room ' . rand(100, 999);

 
 return new AppointmentDTO(
                id: $appointment->id,
                date: $formattedDate,
                time: $formattedTime,
                reason: $appointment->reason,
                status: $statusDisplay,
                doctorName: $doctorName,
                doctorSpecialty: $doctorSpecialty,
                cancelReason: $appointment->cancel_reason,
                location: $location,
                followUp: $appointment->title === 'Follow-up Appointment'

            );
        });
    }
 
}
