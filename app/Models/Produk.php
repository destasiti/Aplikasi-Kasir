<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'ProdukID'; 
    protected $fillable = [
        'NamaProduk',
        'Harga',
        'Stok',
        'KategoriID',
        'FotoProduk'
    ];
    public function stock_in()
    {
        return $this->hasOne(StockIn::class, 'ProdukID')->latest();
    }
    
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'KategoriID'); 
    }

    public function detailpenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->Harga, 0, ',', '.');
    }
}
