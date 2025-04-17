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
            $table->bigIncrements('StockOutID');
            $table->unsignedBigInteger('ProdukID');
            $table->unsignedBigInteger('Jumlah');
            $table->date('TanggalKeluar');
            $table->string('Keterangan')->nullable();
            $table->date('Kedaluwarsa')->nullable(); 
            $table->timestamps();
        });}

            
            
   
    public function down()
    {
        Schema::dropIfExists('stock_out');
    }
}