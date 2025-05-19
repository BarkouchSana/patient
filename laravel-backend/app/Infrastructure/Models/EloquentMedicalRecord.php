<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EloquentMedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_records';

    protected $fillable = [
         
        'patient_id', // Assurez-vous que cela pointe vers la table 'patients'
        'doctor_id',
        'record_type_id',
        'title',
        'description',
        'metadata',
        'record_date',
        'is_confidential',
        'status',
        'version',
        'record_class_type',
        'record_class_id',
        'chart_patient_id',
    ];

    protected $casts = [
        'record_date' => 'datetime',
    
        'metadata' => 'json',
    ];
 

 

    // Relation pour les détails spécifiques du résultat de laboratoire
    public function labResult(): HasOne
    {
        return $this->hasOne(EloquentLabResult::class, 'medical_record_id');
    }

 
}