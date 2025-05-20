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
        $table->string('midtrans_order_id')->nullable();
        $table->string('midtrans_snap_token')->nullable();
    });
}

public function down()
{
    Schema::table('pesanans', function (Blueprint $table) {
        $table->dropColumn(['midtrans_order_id', 'payment_status']);
    });
}
};
