<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi ke customer
            $table->string('nama');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('jenis_barang');
            $table->text('keluhan');
            $table->date('tanggal_pemesanan');

            $table->integer('harga')->nullable(); // diisi oleh admin
            $table->string('estimasi')->nullable(); // estimasi pengerjaan

            $table->enum('status', [
                'Menunggu Konfirmasi Admin',
                'Menunggu Persetujuan Customer',
                'Dalam Proses Servis',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu Konfirmasi Admin');

            $table->timestamps();

            // foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
