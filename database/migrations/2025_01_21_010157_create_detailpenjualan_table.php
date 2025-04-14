<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailpenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailpenjualan', function (Blueprint $table) {
                $table->id('DetailID');
                $table->unsignedBigInteger('PenjualanID');
                $table->foreign('PenjualanID')->references('PenjualanID')->on('penjualan')->onDelete('cascade');
        
                $table->unsignedBigInteger('ProdukID');
                $table->foreign('ProdukID')->references('ProdukID')->on('produk')->onDelete('cascade');
        
                $table->integer('JumlahProduk');
                $table->decimal('SubTotal', 10, 2);
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
        Schema::dropIfExists('detailpenjualan');
    }
}
