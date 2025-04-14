<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $primaryKey = 'PelangganID'; 
    protected $fillable = [
        'NamaPelanggan',
        'Alamat',
        'Email',
        'NomorTelepon',
        'JenisKelamin'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Validasi NomorTelepon hanya angka dan tidak lebih dari 15 karakter
            if ($model->NomorTelepon && !preg_match('/^[0-9]+$/', $model->NomorTelepon)) {
                throw new \Exception("Nomor Telepon hanya boleh berisi angka.");
            }
        });
    }
    
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function detailpenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
