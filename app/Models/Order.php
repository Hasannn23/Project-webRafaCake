<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 1. Daftarkan kolom yang boleh diisi (sesuai migration kita tadi)
    protected $fillable = [
        'user_id',
        'nama_pemesan',
        'nomor_wa',
        'waktu_pengambilan',
        'distribusi',
        'alamat',
        'metode_pembayaran',
        'detail_tambahan', // Kolom JSON
        'status',
        'foto_referensi',
        'total_harga',
        'alasan_penolakan'
    ];

    // 2. Masukkan Casts di sini
    // Fungsinya: detail_tambahan otomatis jadi Array, waktu_pengambilan jadi format Tanggal Jam
    protected $casts = [
        'detail_tambahan' => 'array',
        'waktu_pengambilan' => 'datetime',
    ];

    /**
     * Relasi: Satu Order dimiliki oleh satu User (Member)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Order punya satu Review
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Relasi: Satu Order punya banyak OrderItem
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
