@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"> Tambah Produk Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Isi form berikut untuk menambahkan produk baru ke katalog</p>
        </div>
        <a href="{{ route('admin.katalog') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">← Kembali</a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="nama_kue" class="block text-sm font-medium text-gray-700 mb-1">Nama Kue <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kue" id="nama_kue" value="{{ old('nama_kue') }}" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm"
                    placeholder="Contoh: Brownies Coklat Premium">
                @error('nama_kue') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" id="deskripsi" rows="3" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm"
                    placeholder="Deskripsi produk...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga') }}" required min="0"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm"
                        placeholder="50000">
                    @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" id="kategori" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->nama }}" {{ old('kategori') == $category->nama ? 'selected' : '' }}>{{ $category->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk <span class="text-red-500">*</span></label>
                <input type="file" name="gambar" id="gambar" required accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 cursor-pointer">
                @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="is_promo" id="is_promo" value="1" {{ old('is_promo') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-pink-500 focus:ring-pink-500">
                    <label for="is_promo" class="text-sm font-medium text-gray-700">Aktifkan Promo?</label>
                </div>
                <div>
                    <label for="diskon" class="block text-sm font-medium text-gray-700 mb-1">Diskon (%)</label>
                    <input type="number" name="diskon" id="diskon" value="{{ old('diskon', 0) }}" min="0" max="100"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm"
                        placeholder="0">
                    @error('diskon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.katalog') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-pink-500 rounded-lg hover:bg-pink-600 transition cursor-pointer shadow-sm">
                     Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
