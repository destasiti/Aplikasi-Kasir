<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('PembayaranID');
            $table->unsignedBigInteger('PenjualanID');
            $table->enum('MetodeBayar', ['Cash', 'Transfer', 'E-Wallet', 'Kredit']);
            $table->enum('StatusBayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->bigInteger('JumlahBayar')->nullable();
            $table->bigInteger('Kembalian')->nullable();
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
        Schema::dropIfExists('pembayaran');
    }
}
