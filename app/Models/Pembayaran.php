<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'PembayaranID';
    public $timestamps = true;

    protected $fillable = [
        'PenjualanID',
        'MetodeBayar',
        'StatusBayar',
        'JumlahBayar',
        'Kembalian',
    ];

    /**
     * Relasi ke tabel Penjualan.
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');
    }
}
