<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Kolom-kolom ini yang diizinkan untuk diisi (Mass Assignment)
    protected $fillable = [
        'nama_kue',
        'slug',
        'deskripsi',
        'harga',
        'gambar',
        'kategori',
        'is_promo',
        'diskon'
    ];
}
