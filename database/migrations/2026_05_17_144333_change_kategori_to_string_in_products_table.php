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
        Schema::table('products', function (Blueprint $table) {
            $table->string('kategori')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Kita tidak bisa easily rollback enum definition without knowing the exact previous state, 
            // but we'll try to put it back to original.
            $table->enum('kategori', ['kue_kering', 'donat', 'kue_custom'])->change();
        });
    }
};
