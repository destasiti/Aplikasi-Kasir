<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
        use Notifiable;
    
        protected $table = 'users'; // Pastikan nama tabel benar
        protected $primaryKey = 'UserID'; // Gunakan primary key yang benar
    
        protected $fillable = [
            'name', 
            'email', 
            'password', 
            'role_as'
        ];
    
        protected $hidden = [
            'password',
            'remember_token',
        ];
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
    }
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
   
