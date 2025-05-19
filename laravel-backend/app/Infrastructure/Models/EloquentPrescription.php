<?php
namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentPrescription extends Model
{
    protected $table = 'prescriptions';
    protected $fillable = [
        'chart_patient_id',
        'medication_name',
        'dosage',
        'frequency',
        'duration',
        'start_date',
        'end_date',
        'instructions',
        'refills',
        'status', // Ajouté
        'doctor_name', // Ajouté
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function chartPatient()
    {
        return $this->belongsTo(EloquentChartPatient::class);
    }

    // public function doctor()
    // {
    //     return $this->belongsTo(EloquentDoctor::class);
    // }
}
