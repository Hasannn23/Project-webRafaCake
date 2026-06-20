# Dokumentasi Proyek Rafa Cake

Dokumen ini berisi panduan komprehensif mengenai arsitektur, struktur folder, serta alur kerja kode pada aplikasi **Rafa Cake** (dibangun menggunakan framework Laravel).

---

## 1. Arsitektur & Struktur Folder

Proyek Rafa Cake menggunakan arsitektur **MVC (Model-View-Controller)** bawaan Laravel. Berikut adalah penjelasan direktori dan file penting dalam proyek ini:

### Direktori Utama
- `app/`
  - **`Models/`**: Menyimpan representasi data ke database. Contoh: `Product.php`, `Order.php`, `User.php`. Di sinilah relasi antar tabel didefinisikan (misal: satu *Order* memiliki satu *Review*).
  - **`Http/Controllers/`**: Berisi logika utama aplikasi. Controller menjadi penghubung antara Model (database) dan View (tampilan). Contoh:
    - `AdminController.php`: Mengelola logika untuk sisi Admin (mengelola katalog, pesanan, ulasan, pengguna, kategori).
    - `OrderController.php`: Mengelola proses checkout pesanan pelanggan.
    - `ReviewController.php`: Mengelola input ulasan dari pelanggan.

- `routes/`
  - **`web.php`**: Di sinilah semua jalur URL (routing) aplikasi didaftarkan. File ini menentukan URL mana yang akan memanggil fungsi di Controller mana.

- `resources/`
  - **`views/`**: Folder yang berisi semua tampilan (UI) berbasis HTML/Blade. File berekstensi `.blade.php` berada di sini.
    - `admin/`: Tampilan khusus panel Admin (seperti `katalog/index.blade.php`, `pesanan/index.blade.php`).
    - `Users/`: Tampilan khusus pelanggan/member (seperti `katalog.blade.php` dan `dashboard/dashboardusers.blade.php`).
    - `partials/` & `components/`: Bagian-bagian kecil UI yang bisa digunakan berulang, seperti `about.blade.php`, `footer-contact.blade.php`, atau `navigation.blade.php`.

- `database/`
  - **`migrations/`**: Script untuk membuat tabel-tabel di database (seperti tabel *products*, *orders*, dll).
  - **`seeders/`**: Data awal database (dulu digunakan untuk *dummy data*, sekarang disesuaikan hanya untuk data *essential*).

- `public/`
  - Folder tempat menyimpan file aset statis yang bisa diakses langsung lewat browser (gambar produk, file CSS, dan JS).

---

## 2. Alur Kerja Kode (Code Flow)

Bagian ini menjelaskan bagaimana data dan tampilan terhubung untuk fitur-fitur utama agar Anda dapat dengan mudah melakukan perubahan kode.

### A. Alur Halaman Katalog (Pengunjung & Member)
Halaman utama saat pengunjung membuka website (atau saat menekan tombol "Katalog") berjalan dengan urutan berikut:

1. **Route (`routes/web.php`)**:
   Saat user mengunjungi `/` (root URL), rute mengarahkan logika ke sebuah fungsi *Closure* (bisa juga diarahkan ke controller). Di sana, data ditarik dari Model:
   ```php
   $products = \App\Models\Product::all();
   $categories = \App\Models\Category::pluck('nama')->toArray();
   return view('Users.katalog', compact('products', 'categories'));
   ```
2. **Model (`app/Models/Product.php` & `Category.php`)**:
   Model mengeksekusi *query* ke database dan mengirimkan seluruh produk aktif kembali ke Route.
3. **View (`resources/views/Users/katalog.blade.php`)**:
   Data produk (`$products`) dikirim ke View. View akan melakukan perulangan (`@foreach($products as $product)`) untuk mencetak "kartu produk" satu per satu.
   - Jika pengguna menekan tombol **"Detail Produk"**, aplikasi menggunakan *Alpine.js* untuk merender sebuah *Pop-up Modal* tanpa perlu *reload* halaman. Data dilempar via fungsi Javascript `openProductModal()`.

**Cara Edit Tampilan Katalog**: Buka file `resources/views/Users/katalog.blade.php` lalu modifikasi desain HTML atau CSS (TailwindCSS) pada bagian *Grid Produk* atau struktur Alpine.js (Modal).

### B. Alur Kelola Katalog oleh Admin
Saat admin ingin menambah atau mengedit produk:

1. **Route**: `Route::get('/admin/katalog', [AdminController::class, 'katalog'])`
2. **Controller (`app/Http/Controllers/AdminController.php`)**:
   Fungsi `katalog()` berjalan, menarik data `Product::paginate()`, lalu mengirimkannya ke tampilan admin.
3. **View**: `resources/views/admin/katalog/index.blade.php` (Menampilkan tabel katalog).
4. **Action (Edit/Tambah)**:
   Saat Admin mengirim *form* tambah produk, form lari ke rute `admin.katalog.store` dengan *method POST*.
   `AdminController::storeProduct()` menangkap data request, memvalidasi (termasuk *upload* file gambar ke *storage* lokal), dan menyimpan record baru via Model `Product::create()`.

### C. Mengubah Komponen Berulang (Contoh: Footer)
Aplikasi memisahkan komponen berulang (seperti *navbar* dan *footer*) agar mudah dikelola satu pintu.

Jika ingin **mengubah nomor telepon, alamat, atau teks di Footer**:
1. Cari di View utama (seperti `katalog.blade.php` atau `app.blade.php`) kode yang memanggil komponen, biasanya ditulis sebagai:
   `<x-footer-contact />` atau `@include('partials.footer')`.
2. Buka file asal komponen tersebut. Untuk contoh ini, buka:
   `resources/views/components/footer-contact.blade.php`.
3. Lakukan modifikasi HTML/Teks di file tersebut. Begitu disimpan, footer di seluruh halaman aplikasi yang menggunakan komponen tersebut akan otomatis berubah secara massal.

---

## 3. Catatan Pengembangan Khusus (Developer Notes)
- **Framework UI**: Aplikasi ini menggunakan TailwindCSS. Jika ingin menambah style kustom yang spesifik, tambahkan di *class attribute* secara *inline* atau definisikan konfigurasi tambahan di `tailwind.config.js`.
- **Interaksi Frontend**: Pop-up modal, drawer keranjang belanja (cart), dan filter kategori ditangani menggunakan **Alpine.js**. Hal ini diimplementasikan langsung di dalam file `.blade.php` menggunakan direktif seperti `x-data`, `x-show`, dan `@click`. Selalu berhati-hati dalam men-passing string dari PHP (Blade) ke parameter Alpine.js (selalu gunakan `@json()` atau kombinasi `htmlspecialchars(json_encode(...))` untuk menghindari *bug escape character* / newline).
