<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject 
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    
    protected $hidden = [
        'password',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id'); // 'user_id' is the foreign key on the tasks table
    }

    // JWT Method    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
}
