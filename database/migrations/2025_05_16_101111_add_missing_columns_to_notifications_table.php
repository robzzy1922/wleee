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
        Schema::table('notifications', function (Blueprint $table) {
            // Menambahkan kolom title jika belum ada
            if (!Schema::hasColumn('notifications', 'title')) {
                $table->string('title')->nullable();
            }

            // Menambahkan kolom target_role jika belum ada
            if (!Schema::hasColumn('notifications', 'target_role')) {
                $table->string('target_role')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['title', 'target_role']);
        });
    }
};