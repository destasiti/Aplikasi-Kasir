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
        'Kedaluwarsa',
        'FotoProduk'
    ];

    public function stokMasukTerbaru()
{
    return $this->hasOne(StockIn::class, 'ProdukID');
}
public function stockIns()
{
    return $this->hasMany(StockIn::class, 'ProdukID');
}
public function stockOuts()
{
    return $this->hasMany(StockOut::class, 'ProdukID');
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
