<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_out', function (Blueprint $table) {
            $table->id('Stock_Out_ID');
            $table->unsignedBigInteger('ProdukID');
            $table->integer('Jumlah');
            $table->decimal('HargaJual', 10, 2);
            $table->date('TanggalKeluar');
            $table->timestamps();
        });
    }
            
            
   
    public function down()
    {
        Schema::dropIfExists('stock_out');
    }
}