<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    /**
     * Relasi: Category punya banyak Product (berdasarkan field kategori di products)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori', 'nama');
    }
}
