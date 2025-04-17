<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
  
    use HasFactory;
    protected $table = 'stock_out';
    protected $primaryKey = 'StockOutID';
    protected $fillable = ['ProdukID', 'Jumlah', 'TanggalKeluar', 'Keterangan'];

    public function produk()
{
return $this->belongsTo(Produk::class, 'ProdukID');
}
}

