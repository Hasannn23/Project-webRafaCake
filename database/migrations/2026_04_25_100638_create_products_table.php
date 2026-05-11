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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kue');
            $table->string('slug'); // untuk URL yang cantik
            $table->text('deskripsi');
            $table->integer('harga');
            $table->string('gambar'); // simpan nama file gambarnya
            $table->enum('kategori', ['kue_kering', 'donat', 'kue_custom']);
            $table->boolean('is_promo')->default(false);
            $table->integer('diskon')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
