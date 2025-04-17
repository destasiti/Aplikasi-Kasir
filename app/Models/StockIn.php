<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;
    protected $table = 'stock_in'; 
    protected $primaryKey = 'StockInID';
    protected $fillable = [
        'ProdukID', 
        'SupplierID', 
        'Jumlah', 
        'HargaBeli', 
        'TanggalMasuk', 
        'Kedaluwarsa'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'SupplierID');
    }
}
