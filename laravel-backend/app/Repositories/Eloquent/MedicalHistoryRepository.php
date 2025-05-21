<?php

namespace App\Repositories\Eloquent;

use App\Models\MedicalHistory;
use App\Repositories\Interfaces\MedicalHistoryRepositoryInterface;  
use Carbon\Carbon;

class MedicalHistoryRepository implements MedicalHistoryRepositoryInterface
{
    public function findByPatientId(int $patientId): ?MedicalHistory
    {
        // Le modèle MedicalHistory gère les casts (JSON vers array, timestamp vers Carbon)
        return MedicalHistory::where('patient_id', $patientId)->first();
    }

    public function updateOrCreateByPatientId(int $patientId, array $data): MedicalHistory
    {
        // S'assurer que lastUpdated est bien géré si fourni dans $data
        if (isset($data['lastUpdated']) && !$data['lastUpdated'] instanceof Carbon) {
            $data['lastUpdated'] = Carbon::parse($data['lastUpdated']);
        } elseif (!isset($data['lastUpdated'])) {
            // Mettre à jour lastUpdated par défaut si non fourni,
            // ou laisser le modèle/la base de données le gérer si configuré avec onUpdate('CURRENT_TIMESTAMP')
             $data['lastUpdated'] = Carbon::now();
        }


        return MedicalHistory::updateOrCreate(
            ['patient_id' => $patientId],
            $data
        );
    }

    public function create(array $data): MedicalHistory
    {
        // Assurez-vous que patient_id est dans $data
        // et que lastUpdated est géré
        if (isset($data['lastUpdated']) && !$data['lastUpdated'] instanceof Carbon) {
            $data['lastUpdated'] = Carbon::parse($data['lastUpdated']);
        } elseif (!isset($data['lastUpdated'])) {
             $data['lastUpdated'] = Carbon::now();
        }
        return MedicalHistory::create($data);
    }

    public function update(int $id, array $data): ?MedicalHistory
    {
        $record = MedicalHistory::find($id);

        if (!$record) {
            return null;
        }

        if (isset($data['lastUpdated']) && !$data['lastUpdated'] instanceof Carbon) {
            $data['lastUpdated'] = Carbon::parse($data['lastUpdated']);
        } elseif (!isset($data['lastUpdated']) && array_key_exists('lastUpdated', $data) === false) {
            // Mettre à jour lastUpdated seulement si des données sont modifiées,
            // ou si on veut explicitement le mettre à jour à chaque appel.
            // Pour l'instant, on le met à jour si d'autres données sont présentes.
            if (count(array_diff_key($data, array_flip(['patient_id']))) > 0) { // ne pas considérer patient_id comme une modif de données
                 $data['lastUpdated'] = Carbon::now();
            }
        }


        $record->update($data);
        return $record;
    }
}