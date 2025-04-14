<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('TransaksiID');
            $table->unsignedBigInteger('PenjualanID');
            $table->enum('MetodeBayar', ['Cash', 'Transfer', 'E-Wallet', 'Kredit']);
            $table->enum('StatusBayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->integer('JumlahBayar')->nullable(); 
            $table->integer('Kembalian')->nullable(); 
            $table->timestamps();
         });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
