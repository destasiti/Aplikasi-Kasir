<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
  
        use HasFactory;
        protected $table = 'stock_out';
        protected $primaryKey = 'Stock_Out_ID';
        protected $fillable = ['ProdukID', 'Jumlah', 'HargaJual', 'TanggalKeluar'];
    
        public function produk()
        {
            return $this->belongsTo(Produk::class);
        }
    
    
}
