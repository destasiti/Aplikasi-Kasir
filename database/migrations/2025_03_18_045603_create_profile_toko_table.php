<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_toko', function (Blueprint $table) {
            $table->bigIncrements('TokoID');
                $table->string('NamaToko', 100);
                $table->string('Pemilik', 100);
                $table->string('Email')->unique();
                $table->string('No_Telp', 20);
                $table->text('Alamat');
                $table->string('Logo')->nullable(); 
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
        Schema::dropIfExists('profile_toko');
    }
}
