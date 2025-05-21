<?php
 
 namespace App\Repositories\Eloquent;


 use App\Repositories\Interfaces\VitalSignRepositoryInterface; // Correction du namespace
use App\Models\VitalSign; 
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Collection;
class  VitalSignRepository implements VitalSignRepositoryInterface
{
    public function findLatestByPatientId(int $patientId): ?VitalSign
    {
        return VitalSign::where('patient_id', $patientId)
                        ->orderBy('updated_at', 'desc') // Ou 'created_at' si 'recorded_at' n'est pas toujours défini
                        ->first();
    }

    // public function findById(int $id): ?VitalSign
    // {
    //     return VitalSign::find($id);
    // }

    // public function findByPatientIdPaginated(int $patientId, int $perPage = 15): LengthAwarePaginator
    // {
    //     return VitalSign::where('patient_id', $patientId)
    //                     ->orderBy('recorded_at', 'desc')
    //                     ->paginate($perPage);
    // }

    // public function findAllByPatientId(int $patientId): Collection
    // {
    //     return VitalSign::where('patient_id', $patientId)
    //                     ->orderBy('recorded_at', 'desc')
    //                     ->get();
    // }
    // public function create(array $data): VitalSign
    // {
    //     // Assurez-vous que patient_id est présent dans $data
    //     return VitalSign::create($data);
    // }

    // public function update(int $id, array $data): ?VitalSign
    // {
    //     $vitalSign = $this->findById($id);
    //     if ($vitalSign) {
    //         $vitalSign->update($data);
    //         return $vitalSign;
    //     }
    //     return null;
    // }

    //     /**
    //  * @deprecated Utiliser create() ou update() pour plus de clarté.
    //  */
    // public function save(VitalSign $vitalSign): VitalSign
    // {
    //     $vitalSign->save();
    //     return $vitalSign;
    // }
}