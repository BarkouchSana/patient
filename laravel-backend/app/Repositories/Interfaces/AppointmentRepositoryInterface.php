<?php
namespace App\Repositories\Interfaces;
use App\Models\Appointment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
interface AppointmentRepositoryInterface
{
    /**
     * Récupère l'historique des rendez-vous pour un patient spécifique.
     *
     * @param int $patientId
     * @return Collection<Appointment>
     */
    public function getHistoryByPatientId(int $patientId): Collection;

        /**
     * Récupère les rendez-vous à venir pour un patient spécifique.
     *
     * @param int $patientId
     * @return Collection<Appointment>
     */
    public function getUpcomingByPatientId(int $patientId): Collection;

        /**
     * Récupère un rendez-vous par son ID.
     */
    public function findById(int $id): ?Appointment;

        /**
     * Crée un nouveau rendez-vous.
     */
    public function create(array $data): Appointment;

    /**
     * Met à jour un rendez-vous existant.
     */
    public function update(int $id, array $data): ?Appointment;

    /**
     * Sauvegarde un rendez-vous (crée ou met à jour).
     * @deprecated Utiliser create() ou update() pour plus de clarté.
     */
    public function save(Appointment $appointment): Appointment;

    /**
     * Récupère les rendez-vous paginés pour un patient.
     *
     * @param int $patientId
     * @param int $perPage
     * @param string $status (e.g., 'scheduled', 'completed', 'all')
     * @return LengthAwarePaginator
     */
    public function getByPatientIdPaginated(int $patientId, int $perPage = 15, string $status = 'all'): LengthAwarePaginator;
}
