@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-pink-500 to-rose-400 rounded-2xl shadow-lg p-8 text-white relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-white/10 blur-xl"></div>
        <h2 class="text-2xl font-bold mb-2">Dashboard Admin!</h2>
        <p class="text-pink-100">Kelola pesanan, katalog kue, user, dan review dari sini.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Produk -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Produk</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-pink-600 transition">{{ $totalProduk }}</h3>
                </div>
            </div>
            <a href="{{ route('admin.produk') }}" class="mt-3 inline-block text-xs text-pink-500 hover:text-pink-700 font-medium">Kelola Produk →</a>
        </div>

        <!-- Pesanan Masuk -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pesanan Masuk</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-amber-600 transition">{{ $pesananMasuk }}</h3>
                </div>
            </div>
            <a href="{{ route('admin.pesanan') }}" class="mt-3 inline-block text-xs text-amber-500 hover:text-amber-700 font-medium">Kelola Pesanan →</a>
        </div>

        <!-- Total Member -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Member</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $totalMember }}</h3>
                </div>
            </div>
            <a href="{{ route('admin.users') }}" class="mt-3 inline-block text-xs text-blue-500 hover:text-blue-700 font-medium">Kelola User →</a>
        </div>

        <!-- Total Review -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Review</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-emerald-600 transition">{{ $totalReview }}</h3>
                </div>
            </div>
            <a href="{{ route('admin.review') }}" class="mt-3 inline-block text-xs text-emerald-500 hover:text-emerald-700 font-medium">Kelola Review →</a>
        </div>

        <!-- Total Kategori -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Kategori</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-purple-600 transition">{{ $totalKategori }}</h3>
                </div>
            </div>
            <a href="{{ route('admin.kategori') }}" class="mt-3 inline-block text-xs text-purple-500 hover:text-purple-700 font-medium">Kelola Kategori →</a>
        </div>
    </div>

    <!-- Quick Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h4 class="font-bold text-gray-800 mb-4">Ringkasan Cepat</h4>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-600">Pesanan Selesai</span>
                    <span class="text-sm font-bold text-green-600">{{ $pesananSelesai }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-600">Pesanan Pending</span>
                    <span class="text-sm font-bold text-amber-600">{{ $pesananMasuk }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-600">Produk Terdaftar</span>
                    <span class="text-sm font-bold text-pink-600">{{ $totalProduk }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-600">Member Terdaftar</span>
                    <span class="text-sm font-bold text-blue-600">{{ $totalMember }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h4 class="font-bold text-gray-800 mb-4">Aksi Cepat</h4>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.produk.create') }}" class="flex items-center gap-2 p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition text-sm text-pink-700 font-medium">
                    Tambah Produk
                </a>
                <a href="{{ route('admin.pesanan') }}" class="flex items-center gap-2 p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition text-sm text-amber-700 font-medium">
                    Lihat Pesanan
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-2 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition text-sm text-blue-700 font-medium">
                    Kelola User
                </a>
                <a href="{{ route('admin.kategori') }}" class="flex items-center gap-2 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition text-sm text-purple-700 font-medium">
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.history') }}" class="flex items-center gap-2 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition text-sm text-green-700 font-medium">
                    Lihat History
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
