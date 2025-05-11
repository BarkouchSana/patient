<?php
namespace App\Infrastructure\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
class EloquentUser extends Authenticatable
{


    use HasFactory, Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'name','email','password','phone','status',
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    public function patient()
    {
        return $this->hasOne(EloquentPatient::class, 'user_id');
    }
}
