<?php
namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentDoctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'name', 'specialty', 'license_number', 'availability', 'education', 'experience'
    ];

    public function appointments()
    {
        return $this->hasMany(EloquentAppointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(EloquentPrescription::class);
    }
}
