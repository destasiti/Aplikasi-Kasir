<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = 'profile_toko';
    protected $primaryKey = 'TokoID'; 
    protected $fillable = [
        'NamaToko',
        'Pemilik',
        'Email',
        'No_Telp',
        'Alamat',
        'Logo' 
    ];
}
