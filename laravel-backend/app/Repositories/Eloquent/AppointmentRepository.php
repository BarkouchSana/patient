<?php

namespace App\Repositories\Eloquent;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Pagination\LengthAwarePaginator;
class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function getHistoryByPatientId(int $patientId): Collection
    {
        return Appointment::where('patient_id', $patientId)
            // Historique signifie les rendez-vous passés ou complétés/annulés
            ->where(function ($query) {
                $query->where('date', '<', Date::now()->toDateString())
                      ->orWhereIn('status', ['completed', 'cancelled']);
            })
            ->with(['doctor', 'timeSlot']) 
            ->orderBy('date', 'desc')
            ->orderBy('time_slot_id', 'desc') // Si timeSlot a un start_time, trier par cela aussi
            ->get();
    }

    public function getUpcomingByPatientId(int $patientId): Collection
    {
        return Appointment::where('patient_id', $patientId)
            ->where('date', '>=', Date::now()->toDateString())
            ->whereNotIn('status', ['completed', 'cancelled']) // Exclure les rdv terminés ou annulés
            ->with(['doctor', 'timeSlot'])
            ->orderBy('date', 'asc')
            ->orderBy('time_slot_id', 'asc')
            ->get();
    }

    public function findById(int $id): ?Appointment
    {
        return Appointment::with(['doctor', 'timeSlot', 'patient'])->find($id);
    }

    public function create(array $data): Appointment
    {
        // Assurez-vous que patient_id, doctor_id, time_slot_id sont présents dans $data
        return Appointment::create($data);
    }

    public function update(int $id, array $data): ?Appointment
    {
        $appointment = $this->findById($id);
        if ($appointment) {
            $appointment->update($data);
            return $appointment;
        }
        return null;
    }
     /**
     * @deprecated Utiliser create() ou update() pour plus de clarté.
     */
    public function save(Appointment $appointment): Appointment
    {
        $appointment->save();
        return $appointment;
    }

    public function getByPatientIdPaginated(int $patientId, int $perPage = 15, string $status = 'all'): LengthAwarePaginator
    {
        $query = Appointment::where('patient_id', $patientId)
                            ->with(['doctor', 'timeSlot']);

        if (strtolower($status) !== 'all') {
            $query->where('status', $status);
        }

        return $query->orderBy('date', 'desc')
                      ->orderBy('time_slot_id', 'desc')
                      ->paginate($perPage);
    }
}