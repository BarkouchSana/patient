<?php

namespace App\Repositories\Eloquent;

 
use App\Repositories\Interfaces\PrescriptionRepositoryInterface;
use App\Models\Prescription;
use App\Models\ChartPatient;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator; 

class PrescriptionRepository implements PrescriptionRepositoryInterface
{
 /**
     * Trouve les prescriptions pour un ID de patient donné.
     *
     * @param int $patientId L'ID du modèle Patient.
     * @return Collection<int, Prescription>
     */

     public function findByPatientId(int $patientId): Collection
     {
         Log::info("PrescriptionRepository: Searching prescriptions for patient_id {$patientId}");
 
         // Prescription -> belongsTo -> ChartPatient -> belongsTo -> Patient
         $prescriptions = Prescription::whereHas('chartPatient', function ($query) use ($patientId) {
             $query->where('patient_id', $patientId);
         })
         // Si doctor_name est sur la table Prescription, pas besoin de with spécifique pour ça.
         // Si doctor_name vient d'une relation (ex: Prescription -> Doctor), ajoutez-le ici:
         // ->with(['doctor' => function($q) { $q->select('id', 'name'); }])
         ->orderBy('start_date', 'desc')
         ->get();
 
         Log::info("PrescriptionRepository: Found " . $prescriptions->count() . " prescriptions models for patient_id {$patientId}.");
 
         // Le repository retourne maintenant des modèles Eloquent.
         // La transformation en DTO/Resource se fait plus tard.
         return $prescriptions;
     }

     public function findByPatientIdPaginated(int $patientId, int $perPage = 15): LengthAwarePaginator
     {
         Log::info("PrescriptionRepository: Searching paginated prescriptions for patient_id {$patientId}");
 
         return Prescription::whereHas('chartPatient', function ($query) use ($patientId) {
             $query->where('patient_id', $patientId);
         })
         ->orderBy('start_date', 'desc')
         ->paginate($perPage);
     }

    //  public function create(array $data): Prescription
    //  {
    //      // Assurez-vous que chart_patient_id est présent dans $data
    //      // et que les autres champs requis sont fournis.
    //      return Prescription::create($data);
    //  }
 
    //  public function findById(int $id): ?Prescription
    //  {
    //      return Prescription::find($id);
    //  }
 
    //  public function update(int $id, array $data): ?Prescription
    //  {
    //      $prescription = $this->findById($id);
    //      if ($prescription) {
    //          $prescription->update($data);
    //          return $prescription;
    //      }
    //      return null;
    //  }
}