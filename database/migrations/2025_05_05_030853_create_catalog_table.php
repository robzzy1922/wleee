<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogTable extends Migration
{
    public function up()
    {
        Schema::create('catalog', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kategori');
            $table->string('link_beli')->nullable(); // Boleh kosong jika belum ada
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog');
    }
}
