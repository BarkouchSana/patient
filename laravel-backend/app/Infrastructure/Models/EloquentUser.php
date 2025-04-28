<?php
namespace App\Infrastructure\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class EloquentUser extends Authenticatable
{
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
