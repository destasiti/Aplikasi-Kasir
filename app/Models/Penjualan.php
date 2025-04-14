<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';
    protected $fillable = ['TanggalPenjualan', 'PelangganID', 'TotalHarga','UserID'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'PenjualanID');
    }
    
    public function details()
{
    return $this->hasMany(DetailPenjualan::class, 'PenjualanID');
}
public function user()
{
    return $this->belongsTo(User::class, 'UserID');
}


}
