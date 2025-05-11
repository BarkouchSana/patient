<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentMedicalHistory extends Model
{
    protected $table = 'medical_histories';

    protected $fillable = [
        'patient_id',
        'currentMedicalConditions',
        'pastSurgeries',
        'chronicDiseases',
        'currentMedications',
        'allergies',
        'lastUpdated',
    ];

    protected $casts = [
        'currentMedicalConditions' => 'array',
        'pastSurgeries' => 'array',
        'chronicDiseases' => 'array',
        'currentMedications' => 'array',
        'allergies' => 'array',
    ];
}