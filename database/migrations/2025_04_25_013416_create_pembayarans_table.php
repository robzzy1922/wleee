<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('pembayarans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pelanggan');
        $table->date('tanggal');
        $table->decimal('jumlah', 10, 2);
        $table->string('metode'); // e.g. transfer, e-wallet, dll
        $table->string('status'); // e.g. sukses, pending, gagal
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
