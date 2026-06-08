# Buku Panduan (Manual Book) Website Rafa Cake

## 1. Pendahuluan
Selamat datang di sistem informasi dan pemesanan **Rafa Cake**. Website ini dirancang untuk memudahkan pelanggan dalam melihat katalog kue, melakukan pemesanan, serta memudahkan pihak admin (pemilik toko) dalam mengelola pesanan, produk, dan pengguna.

Buku panduan ini terbagi menjadi 3 bagian utama:
- **Akses Publik (Guest)**
- **Akses Pengguna (Member)**
- **Akses Admin**

---

## 2. Akses Publik (Guest)
Pengunjung yang belum memiliki akun atau belum login dapat mengakses halaman publik.

### 2.1. Melihat Katalog Produk
- **Halaman Utama**: Akses halaman utama (beranda) website untuk melihat **Katalog Produk**.
- Pada halaman ini, pengunjung dapat melihat daftar kue yang tersedia beserta kategorinya.
- Untuk dapat melakukan pemesanan, pengunjung diwajibkan untuk **Login** terlebih dahulu.

---

## 3. Akses Pengguna (Member)
Pengguna yang telah mendaftar dan login (Member) memiliki akses penuh untuk berbelanja dan mengelola pesanan mereka.

### 3.1. Pendaftaran dan Login
- Klik tombol **Login** atau **Register** di sudut kanan atas halaman.
- Jika belum memiliki akun, isi form pendaftaran (Register) dengan data diri yang valid.
- Jika sudah memiliki akun, masukkan Email dan Password untuk Login.

### 3.2. Melakukan Pemesanan Kue
- Setelah login, masuk ke halaman **Katalog Produk**.
- Pilih kue yang ingin dipesan.
- Isi detail pemesanan dan klik tombol **Pesan** (proses melalui route `/pesan-kue`).

### 3.3. Dashboard Member (Riwayat Pesanan)
- Akses menu **Dashboard** pada navigasi akun.
- Pada halaman ini, pengguna dapat melihat daftar pesanan yang pernah dibuat (History Pesanan) dan status pesanan saat ini (misalnya: pending, diproses, selesai).

### 3.4. Kelola Ulasan (Review)
- Melalui halaman Dashboard, pada pesanan yang telah selesai, pengguna dapat memberikan ulasan (rating dan komentar).
- Pengguna juga dapat mengubah (edit) atau menghapus ulasan yang telah diberikan.

### 3.5. Mengelola Profil
- Akses menu **Profile**.
- Pengguna dapat mengubah informasi akun, memperbarui nama, email, atau menghapus akun jika diperlukan.

---

## 4. Akses Admin
Admin memiliki hak akses penuh untuk mengelola keseluruhan konten dan transaksi pada website.

### 4.1. Login Admin
- Masuk melalui halaman login menggunakan akun yang memiliki hak akses sebagai **Admin**.
- Setelah berhasil login, Admin akan otomatis diarahkan atau dapat mengakses menu **Dashboard Admin** (`/admin/dashboard`).

### 4.2. Mengelola Kategori Produk
- Navigasi ke menu **Kategori** (`/admin/kategori`).
- **Tambah Kategori**: Admin dapat menambahkan jenis/kategori kue baru.
- **Edit/Hapus Kategori**: Admin dapat mengubah nama kategori atau menghapusnya jika tidak lagi relevan.

### 4.3. Mengelola Katalog Produk
- Navigasi ke menu **Katalog** (`/admin/katalog`).
- **Tambah Produk**: Klik tambah produk, isi nama kue, deskripsi, harga, dan gambar.
- **Ubah/Hapus Produk**: Admin dapat mengedit detail produk yang sudah ada atau menghapusnya.
- **Status Ketersediaan**: Admin dapat menonaktifkan atau mengaktifkan produk tertentu (*toggle status* ketersediaan).

### 4.4. Mengelola Pesanan (Order)
- Navigasi ke menu **Pesanan** (`/admin/pesanan`).
- Admin akan melihat daftar pesanan masuk dari pelanggan.
- **Update Status Pesanan**: Admin wajib memperbarui status pesanan (contoh: Menunggu Pembayaran, Diproses, Dikirim, Selesai) agar pelanggan dapat memantau pesanan mereka.
- Untuk melihat pesanan yang telah selesai, Admin dapat menuju menu **History Pesanan** (`/admin/history`).

### 4.5. Mengelola Ulasan (Review)
- Navigasi ke menu **Review** (`/admin/review`).
- Admin dapat melihat semua ulasan yang masuk dari pelanggan atas pesanan mereka.
- Admin memiliki hak untuk menghapus ulasan yang tidak pantas (melanggar aturan/spam).

### 4.6. Mengelola Pengguna (Users)
- Navigasi ke menu **Users** (`/admin/users`).
- Admin dapat melihat daftar seluruh pelanggan/member yang terdaftar di website Rafa Cake.
- Admin dapat menambah user baru secara manual, mengedit data user, atau menghapus user.

---

## 5. Penutup
Jika mengalami kendala teknis atau masalah selama penggunaan website, silakan hubungi tim pengembang atau administrator sistem. Buku panduan ini diperbarui sesuai dengan fitur yang tersedia di sistem saat ini.
