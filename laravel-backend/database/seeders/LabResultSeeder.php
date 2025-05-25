<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabResult;
use App\Models\MedicalRecord;
use App\Models\RecordType;
use Carbon\Carbon;

class LabResultSeeder extends Seeder
{
    public function run()
    {
        // Récupérer le type d'enregistrement "Lab Result" par son nom
        $labResultType = RecordType::where('name', 'Lab Result')->first();
        
        if (!$labResultType) {
            // Si le type n'existe pas, on ne peut pas continuer
            return;
        }
        
        // Obtenir tous les dossiers médicaux du type "Lab Result"
        $medicalRecords = MedicalRecord::where('record_type_id', $labResultType->id)->get();
        
        $performedBy = [
            'Dr. Emily Chen, PhD',
            'Dr. Michael Roberts, MD',
            'Lisa Johnson, MT',
            'Robert Wilson, MLT',
            'Personnel du Laboratoire Central'
        ];
        
        $statuses = ['pending', 'completed', 'reviewed'];
        
        $interpretations = [
            'Toutes les valeurs dans la plage normale.',
            'Légère élévation des niveaux de cholestérol. Modifications alimentaires recommandées.',
            'Taux d\'hémoglobine inférieurs à la normale. Supplémentation en fer conseillée.',
            'Élévation du nombre de globules blancs indiquant une possible infection.',
            'Glycémie au-dessus de la plage cible. Ajustement de la médication nécessaire.',
            'Enzymes hépatiques légèrement élevées. Recommandation de test de suivi dans 3 mois.',
        ];

        foreach ($medicalRecords as $record) {
            $recordDate = Carbon::parse($record->record_date);
            $resultDate = $recordDate->copy()->addDays(rand(1, 3));
            
            LabResult::create([
                'medical_record_id' => $record->id,
                'result_date' => $resultDate,
                'performed_by' => $performedBy[array_rand($performedBy)],
                'test_path' => 'lab_results/' . $record->id . '_results.pdf',
                'status' => $statuses[array_rand($statuses)],
                'interpretation' => $interpretations[array_rand($interpretations)],
                'created_at' => $resultDate,
                'updated_at' => $resultDate
            ]);
        }
    }
}