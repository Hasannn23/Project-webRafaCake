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
                'nama_kue' => 'Pizza Spesial Rafa Cake',
                'slug' => Str::slug('Pizza Spesial Rafa Cake'),
                'deskripsi' => 'Pizza homemade dengan topping sosis, keju mozarella, dan saus spesial Rafa Cake yang lezat.',
                'harga' => 65000,
                'gambar' => 'pizza.jpg',
                'kategori' => 'Pizza',
            ],
            [
                'nama_kue' => 'Wedding Cake 3 Susun Elegan',
                'slug' => Str::slug('Wedding Cake 3 Susun Elegan'),
                'deskripsi' => 'Kue pengantin 3 susun dengan hiasan bunga mawar dan base cake yang lembut.',
                'harga' => 1250000,
                'gambar' => 'wedding-cake.jpg',
                'kategori' => 'Wedding cake 3 susun',
            ],
            [
                'nama_kue' => 'Dessert Box Coklat Lumer',
                'slug' => Str::slug('Dessert Box Coklat Lumer'),
                'deskripsi' => 'Aneka dessert box dengan lapisan coklat lumer premium yang memanjakan lidah.',
                'harga' => 45000,
                'gambar' => 'dessert-box.jpg',
                'kategori' => 'Aneka dessert',
            ],
            [
                'nama_kue' => 'Bolu Jadul Mocca Meises',
                'slug' => Str::slug('Bolu Jadul Mocca Meises'),
                'deskripsi' => 'Bolu lembut dengan rasa mocca klasik bertabur meises coklat melimpah.',
                'harga' => 75000,
                'gambar' => 'bolu-jadul.jpg',
                'kategori' => 'Aneka bolu jadul',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}