<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom enum dengan raw SQL
        DB::statement("ALTER TABLE pesanans MODIFY status ENUM(
            'Menunggu Konfirmasi Admin',
            'Diproses',
            'Selesai',
            'Ditolak'
        ) NOT NULL DEFAULT 'Menunggu Konfirmasi Admin'");
    }

    public function down(): void
    {
        // Kembalikan seperti semula (ubah sesuai enum sebelumnya)
        DB::statement("ALTER TABLE pesanans MODIFY status ENUM(
            'Menunggu Konfirmasi Admin',
            'Menunggu Persetujuan' -- tambahkan nilai aslinya jika ada
        ) NOT NULL DEFAULT 'Menunggu Konfirmasi Admin'");
    }
};
