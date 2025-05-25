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
        Log::info("GetAppointmentHistoryService initialized");
    }

    public function execute(int $patientId): Collection
    {
        Log::info("GetAppointmentHistoryService@execute: Starting to fetch appointment history", [
            'patient_id' => $patientId
        ]);
        
        try {
            $appointments = $this->appointmentRepository->getHistoryByPatientId($patientId);
            
            Log::info("GetAppointmentHistoryService@execute: Found appointments", [
                'patient_id' => $patientId,
                'count' => $appointments->count()
            ]);
            
            $mappedAppointments = $appointments->map(function (Appointment $appointment) {
                Log::debug("GetAppointmentHistoryService@execute: Mapping appointment to DTO", [
                    'appointment_id' => $appointment->id,
                    'status' => $appointment->status,
                    'date' => $appointment->date
                ]);
                
                try {
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
                } catch (\Exception $e) {
                    Log::error("GetAppointmentHistoryService@execute: Error mapping appointment to DTO", [
                        'appointment_id' => $appointment->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    // Retourner un DTO minimal en cas d'erreur
                    return new AppointmentDTO(
                        id: $appointment->id,
                        date: $appointment->date ? $appointment->date->format('F jS, Y') : 'Unknown',
                        time: 'N/A',
                        reason: $appointment->reason ?? 'No reason provided',
                        status: ucfirst($appointment->status ?? 'unknown'),
                        doctorName: 'N/A'
                    );
                }
            });
            
            Log::info("GetAppointmentHistoryService@execute: Successfully mapped appointments to DTOs", [
                'patient_id' => $patientId,
                'count' => $mappedAppointments->count()
            ]);
            
            return $mappedAppointments;
        } catch (\Exception $e) {
            Log::error("GetAppointmentHistoryService@execute: Exception occurred", [
                'patient_id' => $patientId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Retourner une collection vide en cas d'erreur
            return collect([]);
        }
    }
}