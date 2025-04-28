<?php
namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentPatient extends Model
{
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
}
