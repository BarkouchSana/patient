<?php
namespace App\Repositories\Eloquent;

use App\Models\Patient;
use App\Repositories\Interfaces\PatientRepositoryInterface;

use Illuminate\Database\Eloquent\Collection;

class PatientRepository implements PatientRepositoryInterface
{

    public function findById(int $id): ?Patient
    {
        return Patient::find($id);
    }

    public function findByUserId(int $userId): ?Patient
    {
        return Patient::where('user_id', $userId)->first();
    }

    public function getAll(): Collection
    {
        return Patient::all();
    }

    public function save(Patient $patient): Patient
    {
        // La logique de création/mise à jour est gérée par Eloquent directement sur l'objet Patient
        // Si $patient est une nouvelle instance non sauvegardée, save() l'insérera.
        // Si $patient est une instance existante (récupérée de la DB), save() la mettra à jour.
        $patient->save();
        return $patient;
    }

    /**
     * Si vous avez besoin d'une méthode spécifique pour créer ou mettre à jour
     * avec un tableau de données, vous pouvez l'ajouter.
     * Par exemple :
     */
    // public function create(array $data): Patient
    // {
    //     return Patient::create($data);
    // }

    // public function update(int $id, array $data): ?Patient
    // {
    //     $patient = $this->findById($id);
    //     if ($patient) {
    //         $patient->update($data);
    //         return $patient;
    //     }
    //     return null;
    // }

   
}
