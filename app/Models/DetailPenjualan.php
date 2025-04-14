<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $table = 'detailpenjualan';
    protected $primaryKey = 'DetailID';
    protected $fillable = ['PenjualanID', 'ProdukID', 'JumlahProduk', 'SubTotal'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID');
    }



    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }
    
}