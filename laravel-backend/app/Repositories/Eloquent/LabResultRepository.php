<?php

namespace App\Repositories\Eloquent;

 
use App\Repositories\Interfaces\LabResultRepositoryInterface;
use App\Models\LabResult;
use App\Models\MedicalRecord;
use App\Models\ChartPatient;
use App\Models\User;
use App\DTOs\LabResultDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
 

class LabResultRepository implements LabResultRepositoryInterface
{
 /**
     * Récupère les résultats de laboratoire pour un patient donné (via son ID de Patient).
     * Les modèles LabResult retournés auront leurs relations medicalRecord et medicalRecord.doctor chargées.
     *
     * @param int $patientId L'ID du modèle Patient.
     * @return Collection<int, LabResult>
     */
    public function findByPatientId(int $patientId): Collection
    {
    Log::info("LabResultRepository: Searching lab results for patient_id {$patientId}");
        
       // Récupérer les résultats de laboratoire avec les relations nécessaires
        // Utiliser eager loading pour charger toutes les relations en une seule requête
        $labResults = LabResult::with([
            'medicalRecord' => function ($query) {
                $query->select(['id', 'title', 'description', 'record_date', 'doctor_id', 'patient_id', 'chart_patient_id']);
            },
            'medicalRecord.doctor' => function ($query) {
                $query->select(['id', 'name']);
            },
            'medicalRecord.chartPatient' => function ($query) {
                $query->select(['id', 'patient_id']);
            }
        ])
        ->whereHas('medicalRecord', function($query) use ($patientId) {
            $query->where('patient_id', $patientId);
        })
        ->orderBy('result_date', 'desc')
        ->get();
        
      Log::info("LabResultRepository: Found {$labResults->count()} lab results for patient_id {$patientId}.");
    
        // Mapper les résultats en DTOs
        
        return $labResults->map(function ($labResult) {
                        // Vérifier et préparer toutes les données nécessaires pour le DTO
                        $medicalRecord = $labResult->medicalRecord;
                        $doctorName = $medicalRecord->doctor ? $medicalRecord->doctor->name : 'Unknown Doctor';
                        
                        return new LabResultDTO(
                            $labResult->id,
                            $labResult->medical_record_id,
                            $labResult->result_date ?? now(), // Fallback si null
                            $labResult->performed_by ?? 'Unknown',
                            $labResult->test_path,
                            $labResult->status ?? 'pending',
                            $labResult->interpretation ?? 'No interpretation available',
                            $medicalRecord->title ?? 'Laboratory Test', // Utilisation de title depuis medical_records
                            $medicalRecord->description ?? 'No summary available', // Utilisation de description comme summary
                            $doctorName, // Vérification de l'existence du médecin
                            $medicalRecord->record_date ?? $labResult->created_at // Utilisation de record_date comme recordDate
                        );
        });
        }
     

        public function findByPatientIdPaginated(int $patientId, int $perPage = 15): LengthAwarePaginator
        {
            Log::info("LabResultRepository: Searching paginated lab results for patient_id {$patientId}");
    
            return LabResult::with([
                    'medicalRecord' => function ($query) {
                        $query->select(['id', 'chart_patient_id', 'doctor_id', 'title', 'description', 'record_date', 'patient_id']);
                    },
                    'medicalRecord.doctor' => function ($query) {
                        $query->select(['id', 'name']);
                    },
                    'medicalRecord.chartPatient' => function ($query) {
                        $query->select(['id', 'patient_id']);
                    }
                ])
                ->whereHas('medicalRecord', function($query) use ($patientId) {
                    $query->where('patient_id', $patientId);
                })
                ->orderBy('result_date', 'desc')
                ->paginate($perPage);
        }

        // public function create(array $data): LabResult
        // {
        //     // Assurez-vous que medical_record_id est présent dans $data
        //     // et que les autres champs requis par LabResult sont fournis.
        //     return LabResult::create($data);
        // }
    /**
     * Trouve un résultat de laboratoire par son ID.
     * 
     * @param int $id
     * @return LabResult|null
     */
    public function findById(int $id): ?LabResult
    {
        return LabResult::with([
            'medicalRecord' => function ($query) {
                $query->select(['id', 'chart_patient_id', 'doctor_id', 'title', 'description', 'record_date', 'patient_id']);
            },
            'medicalRecord.doctor' => function ($query) {
                $query->select(['id', 'name']);
            },
            'medicalRecord.chartPatient' => function ($query) {
                $query->select(['id', 'patient_id']);
            }
        ])->find($id);
    }
    
        // public function update(int $id, array $data): ?LabResult
        // {
        //     $labResult = $this->findById($id); // findById charge déjà les relations
        //     if ($labResult) {
        //         $labResult->update($data);
        //         return $labResult;
        //     }
        //     return null;
        // }
   
}