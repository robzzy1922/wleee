<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('estimasi_waktu')->nullable();
            $table->string('status_pesanan')->default('Menunggu Konfirmasi Admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->dropColumn(['estimasi_waktu', 'status_pesanan']);
    });
}
};
