<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecordType;

class RecordTypeSeeder extends Seeder
{
    public function run()
    {
        $recordTypes = [
            [
                'name' => 'Lab Result',
                'code' => 'LAB-RES',
                'description' => 'Résultats d\'analyses de laboratoire',
                'metadata_schema' => [
                    'lab_name' => 'string',
                    'test_type' => 'string',
                    'reference_range' => 'string'
                ],
                'requires_attachment' => true,
                'is_active' => true
            ],
            [
                'name' => 'Imaging',
                'code' => 'IMG',
                'description' => 'Études de radiologie et d\'imagerie',
                'metadata_schema' => [
                    'imaging_type' => 'string',
                    'body_region' => 'string',
                    'contrast_used' => 'boolean'
                ],
                'requires_attachment' => true,
                'is_active' => true
            ],
            [
                'name' => 'Prescription',
                'code' => 'PRESC',
                'description' => 'Prescriptions médicales',
                'metadata_schema' => [
                    'medication' => 'string',
                    'dosage' => 'string',
                    'frequency' => 'string',
                    'duration' => 'string'
                ],
                'requires_attachment' => false,
                'is_active' => true
            ],
            [
                'name' => 'Progress Note',
                'code' => 'PROG-N',
                'description' => 'Notes de progression du médecin',
                'metadata_schema' => [
                    'visit_type' => 'string',
                    'vital_signs' => 'object',
                    'chief_complaint' => 'string'
                ],
                'requires_attachment' => false,
                'is_active' => true
            ],
            [
                'name' => 'Consultation',
                'code' => 'CONSULT',
                'description' => 'Rapports de consultation spécialisée',
                'metadata_schema' => [
                    'specialist' => 'string',
                    'specialty' => 'string',
                    'referral_reason' => 'string'
                ],
                'requires_attachment' => false,
                'is_active' => true
            ],
            [
                'name' => 'Procedure',
                'code' => 'PROC',
                'description' => 'Procédures chirurgicales et non chirurgicales',
                'metadata_schema' => [
                    'procedure_type' => 'string',
                    'anesthesia' => 'string',
                    'duration' => 'integer'
                ],
                'requires_attachment' => true,
                'is_active' => true
            ],
            [
                'name' => 'Vaccination',
                'code' => 'VAC',
                'description' => 'Registre de vaccinations',
                'metadata_schema' => [
                    'vaccine_name' => 'string',
                    'lot_number' => 'string',
                    'site' => 'string',
                    'dose' => 'string'
                ],
                'requires_attachment' => false,
                'is_active' => true
            ],
            [
                'name' => 'Allergy',
                'code' => 'ALLERGY',
                'description' => 'Documentation d\'allergies',
                'metadata_schema' => [
                    'allergen' => 'string',
                    'reaction' => 'string',
                    'severity' => 'string'
                ],
                'requires_attachment' => false,
                'is_active' => true
            ],
            [
                'name' => 'Problem',
                'code' => 'PROB',
                'description' => 'Éléments de la liste de problèmes',
                'metadata_schema' => [
                    'condition' => 'string',
                    'onset_date' => 'date',
                    'status' => 'string'
                ],
                'requires_attachment' => false,
                'is_active' => true
            ],
            [
                'name' => 'Vital Signs',
                'code' => 'VITAL',
                'description' => 'Mesures des signes vitaux',
                'metadata_schema' => [
                    'blood_pressure' => 'string',
                    'heart_rate' => 'integer',
                    'temperature' => 'float',
                    'respiratory_rate' => 'integer',
                    'oxygen_saturation' => 'integer'
                ],
                'requires_attachment' => false,
                'is_active' => true
            ],
        ];

        foreach ($recordTypes as $type) {
            RecordType::create($type);
        }
    }
}