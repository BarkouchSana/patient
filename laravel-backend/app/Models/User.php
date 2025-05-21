<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Tymon\JWTAuth\Contracts\JWTSubject; // Nécessaire si vous utilisez JWT pour l'authentification
   
class User extends Authenticatable implements JWTSubject
{


    use HasFactory, Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'name','email','password','phone','status',
    ];

    protected $hidden = [
        'password','remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime', // Ajouté pour la cohérence
    ];
    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }


        // Méthodes JWTSubject
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
    
        public function getJWTCustomClaims()
        {
            return [];
        }
}
