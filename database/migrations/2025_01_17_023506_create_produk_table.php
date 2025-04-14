<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
        $table->id('ProdukID');
        $table->string('NamaProduk');
        $table->decimal('Harga', 10, 2);
        $table->integer('Stok')->default(0); 
        $table->unsignedBigInteger('KategoriID'); 
        $table->string('FotoProduk')->nullable(); // Simpan nama file gambar
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
        Schema::dropIfExists('produk');
    }
}
