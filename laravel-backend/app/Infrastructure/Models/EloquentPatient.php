<?php
namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EloquentPatient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $fillable = [
        'user_id','registration_date'
    ];

    public function user()
    {
        return $this->belongsTo(EloquentUser::class, 'user_id');
    }

    public function personalInfo()
    {
        return $this->hasOne(EloquentPersonalInfo::class, 'patient_id');
    }

    // public function medicalHistory()
    // {
    //     return $this->hasOne(MedicalHistory::class);
    // }

    public function appointments()
    {
        return $this->hasMany(EloquentAppointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(EloquentPrescription::class);
    }
}
