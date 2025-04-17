<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInTable extends Migration
{
   
    public function up()
    {
        Schema::create('stock_in', function (Blueprint $table) {
            $table->bigIncrements('StockInID');
            $table->unsignedBigInteger('ProdukID');
            $table->unsignedBigInteger('SupplierID');
            $table->integer('Jumlah');
            $table->decimal('HargaBeli', 15, 2)->nullable(); 
            $table->date('TanggalMasuk');
            $table->date('Kedaluwarsa')->nullable();
        $table->timestamps();
    });
    }

    
        public function down()
        {
            Schema::dropIfExists('stock_in');
        }
    }
    
      