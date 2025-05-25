<?php 

namespace App\Http\Controllers\Api;

 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\GetAppointmentHistoryService; // Ensure this is the correct namespace
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\Appointment; // Assuming Appointment model is in App\Models
use Carbon\Carbon; // For date manipulation
use App\DTOs\AppointmentDTO; // Assuming AppointmentDTO is in App\DTOs
use App\Models\Patient; // Assuming Patient model is in App\Models
use Illuminate\Support\Facades\Log; // For logging
class AppointmentHistoryController extends Controller
{

    private GetAppointmentHistoryService $getAppointmentHistoryService;

    public function __construct(GetAppointmentHistoryService $getAppointmentHistoryService)
    {
        $this->getAppointmentHistoryService = $getAppointmentHistoryService;
       Log::info("AppointmentHistoryController initialized");
    }

 



    public function index(Request $request): JsonResponse
    {
        // Récupérer le premier patient de la base de données
        $patient = Patient::first();
        
        if (!$patient) {
             Log::error("AppointmentHistoryController@index: No patient found in database");
            return response()->json(['error' => 'No patient record found in the database.'], 404);
        
        }
                Log::info("AppointmentHistoryController@index: Using first patient", [
            'patient_id' => $patient->id,
            'patient_user_id' => $patient->user_id ?? 'null'
        ]);
        
        
         try {
        // Utiliser l'ID du premier patient
        $appointmentDTOs = $this->getAppointmentHistoryService->execute($patient->id);

       Log::info("AppointmentHistoryController@index: Retrieved appointment history", [
                'count' => $appointmentDTOs->count(),
                'patient_id' => $patient->id
            ]);
            if ($appointmentDTOs->isEmpty()) {
                Log::info("AppointmentHistoryController@index: No appointments found for patient", [
                    'patient_id' => $patient->id
                ]);
                // Retournons un tableau vide plutôt qu'une erreur 404
                return response()->json([]);
            }

            return response()->json($appointmentDTOs);
    }catch (\Exception $e) {
            Log::error("AppointmentHistoryController@index: Exception while retrieving appointments", [
                'patient_id' => $patient->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'An error occurred while retrieving appointment history.'], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        Log::info("AppointmentHistoryController@show: Fetching appointment details", ['appointment_id' => $id]);
        
        try {
            $appointment = Appointment::with(['doctor', 'timeSlot'])->find($id);
            
            if (!$appointment) {
                Log::warning("AppointmentHistoryController@show: Appointment not found", ['appointment_id' => $id]);
                return response()->json(['error' => 'Appointment not found'], 404);
            }
            
            Log::info("AppointmentHistoryController@show: Appointment found", [
                'appointment_id' => $id,
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'status' => $appointment->status
            ]);
            // Format date as "Month DaySuffix, Year" e.g., "May 10th, 2023"
            $formattedDate = Carbon::parse($appointment->date)->format('F jS, Y');

            // Format time as "HH:MM - HH:MM"
            $formattedTime = 'N/A';
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
$doctorName = $appointment->doctor ? $appointment->doctor->name : 'N/A';
            $doctorSpecialty = $appointment->doctor ? $appointment->doctor->specialty : 'General Medicine';

            // Créer un DTO enrichi
            $appointmentDTO = new AppointmentDTO(
                id: $appointment->id,
                date: $formattedDate,
                time: $formattedTime,
                reason: $appointment->reason,
                status: $statusDisplay,
                doctorName: $doctorName,
                doctorSpecialty: $doctorSpecialty,
                cancelReason: $appointment->cancel_reason,
                location: 'Medical Center, Room ' . rand(100, 999), // Exemple
                followUp: str_contains(strtolower($appointment->title ?? ''), 'follow'),
                notes: ['Patient requested morning appointment', 'Bring previous test results']
            );
             Log::info("AppointmentHistoryController@show: Successfully created appointment DTO", ['appointment_id' => $id]);
            
            return response()->json($appointmentDTO);
        } catch (\Exception $e) {
            Log::error("AppointmentHistoryController@show: Exception while fetching appointment", [
                'appointment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'An error occurred while retrieving appointment details.'], 500);
        }
    }

    public function cancel(int $id, Request $request): JsonResponse
    {
        Log::info("AppointmentHistoryController@cancel: Request to cancel appointment", [
            'appointment_id' => $id,
            'reason' => $request->input('reason')
        ]);
        
        try {
            $appointment = Appointment::find($id);
            
            if (!$appointment) {
                Log::warning("AppointmentHistoryController@cancel: Appointment not found", ['appointment_id' => $id]);
                return response()->json(['error' => 'Appointment not found'], 404);
            }
            
            Log::info("AppointmentHistoryController@cancel: Appointment found", [
                'appointment_id' => $id,
                'patient_id' => $appointment->patient_id,
                'status' => $appointment->status
            ]);
             // Vérifier si le rendez-vous peut être annulé
            if (in_array($appointment->status, ['completed', 'cancelled'])) {
                Log::warning("AppointmentHistoryController@cancel: Cannot cancel appointment with status", [
                    'appointment_id' => $id,
                    'status' => $appointment->status
                ]);
                
                return response()->json(
                    ['error' => 'Cannot cancel appointment with status: ' . $appointment->status], 
                    400
                );
            }
            
            // Mise à jour du statut et de la raison d'annulation
            $appointment->status = 'cancelled';
            $appointment->cancel_reason = $request->input('reason', 'Cancelled by patient');
            $appointment->save();
            
            Log::info("AppointmentHistoryController@cancel: Appointment cancelled successfully", [
                'appointment_id' => $id,
                'reason' => $appointment->cancel_reason
            ]);
            
            return response()->json(['message' => 'Appointment cancelled successfully']);
        } catch (\Exception $e) {
            Log::error("AppointmentHistoryController@cancel: Exception while cancelling appointment", [
                'appointment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'An error occurred while cancelling the appointment.'], 500);
        }
    }
}
