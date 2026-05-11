<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama_kue' => 'Donat Karakter Isi 6',
                'slug' => Str::slug('Donat Karakter Isi 6'),
                'deskripsi' => 'Donat lembut dengan berbagai bentuk karakter lucu, cocok untuk ulang tahun anak.',
                'harga' => 55000,
                'gambar' => 'donat-karakter.jpg',
                'kategori' => 'donat',
            ],
            [
                'nama_kue' => 'Custom Cake Spiderman',
                'slug' => Str::slug('Custom Cake Spiderman'),
                'deskripsi' => 'Kue ulang tahun tema Spiderman dengan base cake coklat yang lumer.',
                'harga' => 250000,
                'gambar' => 'custom-spiderman.jpg',
                'kategori' => 'kue_custom',
            ],
            [
                'nama_kue' => 'Nastar Premium Wisman',
                'slug' => Str::slug('Nastar Premium Wisman'),
                'deskripsi' => 'Kue kering nastar dengan selai nanas asli dan mentega wisman yang sangat lembut.',
                'harga' => 85000,
                'gambar' => 'nastar.jpg',
                'kategori' => 'kue_kering',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}