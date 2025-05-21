<?php
namespace App\Repositories\Eloquent;

use App\Models\PersonalInfo;
use App\Repositories\Interfaces\PersonalInfoRepositoryInterface;
use App\Infrastructure\Models\EloquentPersonalInfo;

class PersonalInfoRepository implements PersonalInfoRepositoryInterface
{
    
   
        public function findByPatientId(int $patientId): ?PersonalInfo
        {
            // Le modèle PersonalInfo gère les casts (e.g., birthdate vers Carbon)
            // et les noms de colonnes sont ceux définis dans le modèle.
            return PersonalInfo::where('patient_id', $patientId)->first();
        }

            /**
     * Persiste les informations personnelles (insert ou update).
     * L'objet PersonalInfo passé est sauvegardé.
     */
    public function save(PersonalInfo $personalInfo): PersonalInfo
    {
        // Les attributs de $personalInfo doivent correspondre aux colonnes de la base de données
        // et être dans $fillable si c'est une nouvelle création via cette méthode.
        $personalInfo->save();
        return $personalInfo;
    }
    public function updateOrCreateByPatientId(int $patientId, array $data): PersonalInfo
    {
        // Les clés du tableau $data doivent correspondre aux attributs $fillable
        // du modèle App\Models\PersonalInfo.
        // Par exemple, $data['profile_image'] et non $data['photo'].
        return PersonalInfo::updateOrCreate(
            ['patient_id' => $patientId],
            $data // $data doit contenir des clés comme 'name', 'surname', 'profile_image', etc.
        );
    }

    public function create(array $data): PersonalInfo
    {
        // Assurez-vous que patient_id est dans $data
        // et que les autres clés correspondent aux attributs $fillable.
        return PersonalInfo::create($data);
    }
    public function update(int $id, array $data): ?PersonalInfo
    {
        $personalInfo = PersonalInfo::find($id);
        if ($personalInfo) {
            // Les clés du tableau $data doivent correspondre aux attributs $fillable.
            $personalInfo->update($data);
            return $personalInfo;
        }
        return null;
    }
 
}
