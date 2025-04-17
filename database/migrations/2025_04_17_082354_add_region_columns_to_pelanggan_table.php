<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionColumnsToPelangganTable extends Migration
{
    public function up()
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->char('province_id', 2)->nullable()->after('Alamat');
            $table->char('regency_id', 4)->nullable()->after('province_id');
            $table->char('district_id', 7)->nullable()->after('regency_id');
            $table->char('village_id', 10)->nullable()->after('district_id');
        });
    }

    public function down()
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn(['province_id', 'regency_id', 'district_id', 'village_id']);
        });
    }
}