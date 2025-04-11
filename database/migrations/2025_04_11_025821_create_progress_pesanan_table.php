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
    Schema::create('progress_pesanan', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pesanan_id');
        $table->string('status')->nullable();
        $table->timestamps();

        $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_pesanan');
    }
};
