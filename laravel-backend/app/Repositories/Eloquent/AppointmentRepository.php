<?php

namespace App\Repositories\Eloquent;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function getHistoryByPatientId(int $patientId): Collection
    {
        Log::info("AppointmentRepository@getHistoryByPatientId: Fetching appointment history", [
            'patient_id' => $patientId
        ]);
        
        $appointments = Appointment::where('patient_id', $patientId)
            // Historique signifie les rendez-vous passés ou complétés/annulés
            ->where(function ($query) {
                $query->where('date', '<', Date::now()->toDateString())
                      ->orWhereIn('status', ['completed', 'cancelled']);
            })
            ->with(['doctor', 'timeSlot']) 
            ->orderBy('date', 'desc')
            ->orderBy('time_slot_id', 'desc')
            ->get();
            
        Log::info("AppointmentRepository@getHistoryByPatientId: Found appointments", [
            'patient_id' => $patientId,
            'count' => $appointments->count()
        ]);
        
        return $appointments;
    }

    public function getUpcomingByPatientId(int $patientId): Collection
    {
        Log::info("AppointmentRepository@getUpcomingByPatientId: Fetching upcoming appointments", [
            'patient_id' => $patientId
        ]);
        
        $appointments = Appointment::where('patient_id', $patientId)
            ->where('date', '>=', Date::now()->toDateString())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['doctor', 'timeSlot'])
            ->orderBy('date', 'asc')
            ->orderBy('time_slot_id', 'asc')
            ->get();
            
        Log::info("AppointmentRepository@getUpcomingByPatientId: Found upcoming appointments", [
            'patient_id' => $patientId,
            'count' => $appointments->count()
        ]);
        
        return $appointments;
    }

    public function findById(int $id): ?Appointment
    {
        Log::info("AppointmentRepository@findById: Fetching appointment by ID", [
            'appointment_id' => $id
        ]);
        
        $appointment = Appointment::with(['doctor', 'timeSlot', 'patient'])->find($id);
        
        if ($appointment) {
            Log::info("AppointmentRepository@findById: Appointment found", [
                'appointment_id' => $id,
                'patient_id' => $appointment->patient_id,
                'status' => $appointment->status
            ]);
        } else {
            Log::warning("AppointmentRepository@findById: Appointment not found", [
                'appointment_id' => $id
            ]);
        }
        
        return $appointment;
    }

    public function create(array $data): Appointment
    {
        Log::info("AppointmentRepository@create: Creating new appointment", [
            'patient_id' => $data['patient_id'] ?? 'missing',
            'doctor_id' => $data['doctor_id'] ?? 'missing',
            'date' => $data['date'] ?? 'missing'
        ]);
        
        $appointment = Appointment::create($data);
        
        Log::info("AppointmentRepository@create: Appointment created", [
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'status' => $appointment->status
        ]);
        
        return $appointment;
    }

    public function update(int $id, array $data): ?Appointment
    {
        Log::info("AppointmentRepository@update: Updating appointment", [
            'appointment_id' => $id,
            'data_keys' => array_keys($data)
        ]);
        
        $appointment = $this->findById($id);
        if ($appointment) {
            $appointment->update($data);
            
            Log::info("AppointmentRepository@update: Appointment updated", [
                'appointment_id' => $id,
                'patient_id' => $appointment->patient_id,
                'status' => $appointment->status
            ]);
            
            return $appointment;
        }
        
        Log::warning("AppointmentRepository@update: Cannot update - Appointment not found", [
            'appointment_id' => $id
        ]);
        
        return null;
    }

    /**
     * @deprecated Utiliser create() ou update() pour plus de clarté.
     */
    public function save(Appointment $appointment): Appointment
    {
        Log::info("AppointmentRepository@save: Saving appointment", [
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'status' => $appointment->status
        ]);
        
        $appointment->save();
        
        Log::info("AppointmentRepository@save: Appointment saved", [
            'appointment_id' => $appointment->id
        ]);
        
        return $appointment;
    }

    public function getByPatientIdPaginated(int $patientId, int $perPage = 15, string $status = 'all'): LengthAwarePaginator
    {
        Log::info("AppointmentRepository@getByPatientIdPaginated: Fetching paginated appointments", [
            'patient_id' => $patientId,
            'per_page' => $perPage,
            'status_filter' => $status
        ]);
        
        $query = Appointment::where('patient_id', $patientId)
                          ->with(['doctor', 'timeSlot']);

        if (strtolower($status) !== 'all') {
            $query->where('status', $status);
        }

        $results = $query->orderBy('date', 'desc')
                      ->orderBy('time_slot_id', 'desc')
                      ->paginate($perPage);
                      
        Log::info("AppointmentRepository@getByPatientIdPaginated: Fetched paginated results", [
            'patient_id' => $patientId,
            'total' => $results->total(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage()
        ]);
        
        return $results;
    }
}