<?php
namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentPrescription extends Model
{
    protected $table = 'prescriptions';
    protected $fillable = [
      'patient_id', 'doctor_id', 'name','dosage',
      'start_date','end_date','quantity'
    ];
    public function patient()
    {
        return $this->belongsTo(EloquentPatient ::class);
    }

    public function doctor()
    {
        return $this->belongsTo(EloquentDoctor::class);
    }
}
