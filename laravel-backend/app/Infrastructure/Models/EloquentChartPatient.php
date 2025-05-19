<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentChartPatient extends Model
{
    use HasFactory;

    protected $table = 'chart_patients'; // Confirmez le nom de la table

    protected $fillable = [
        'patient_id', // Référence à users.id
        'diagnosis',
        'chief_complaint',
        'status',
        'followup_date',
    ];

    protected $casts = [
        'followup_date' => 'datetime',
    ];

    public function patient(): BelongsTo // Renommé pour clarté, si 'patient_id' est user_id
    {
        return $this->belongsTo(EloquentPatient::class, 'patient_id');
    }
    public function doctor(): BelongsTo // Médecin principal associé à ce dossier patient
    {
        return $this->belongsTo(EloquentDoctor::class, 'doctor_id');
    }
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(EloquentMedicalRecord::class, 'chart_patient_id');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(EloquentPrescription::class, 'chart_patient_id');
    }
}