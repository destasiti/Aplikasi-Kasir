<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Import model IndoRegion
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $primaryKey = 'PelangganID'; 
protected $fillable = [
    'NamaPelanggan',
    'Alamat',
    'province_id',
    'regency_id', // Pastikan nama field konsisten
    'district_id',
    'village_id',
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
    
    
    public function village()
    {
        return $this->belongsTo(\App\Models\Village::class, 'village_id');
    }
    
    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id');
    }
    
    public function regency()
    {
        return $this->belongsTo(\App\Models\Regency::class, 'regency_id');
    }
    
    public function province()
    {
        return $this->belongsTo(\App\Models\Province::class, 'province_id');
    }
    
}