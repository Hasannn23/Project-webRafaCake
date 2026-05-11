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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Umum (Ada di semua kategori)
            $table->string('nama_pemesan');
            $table->string('nomor_wa');
            $table->dateTime('waktu_pengambilan'); // Gabungan tanggal dan jam
            $table->enum('distribusi', ['ambil_sendiri', 'ojek']);
            $table->text('alamat')->nullable(); // Diisi jika pilih ojek
            $table->enum('metode_pembayaran', ['cash', 'transfer']);
            
            // Data Spesifik (Disimpan dalam bentuk JSON)
            // Kolom ini akan menyimpan Base Cake, Ukuran, Lilin, dll secara otomatis
            $table->json('detail_tambahan')->nullable(); 
        
            // Status & Admin
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->string('foto_referensi')->nullable(); // Untuk gambar request custom cake
            $table->integer('total_harga')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
