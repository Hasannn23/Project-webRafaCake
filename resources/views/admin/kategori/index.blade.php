@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ 
    showCreateModal: false, 
    showEditModal: false, 
    editId: null, editNama: '' 
}">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"> Kelola Kategori</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola semua kategori produk kue Rafa Cake</p>
        </div>
        <button @click="showCreateModal = true" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition flex items-center gap-2 text-sm cursor-pointer">
             Tambah Kategori
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($categories->isEmpty())
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <p class="text-gray-500 mt-3">Belum ada kategori. Tambahkan kategori pertama!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-4 font-semibold">#</th>
                            <th class="p-4 font-semibold">Nama Kategori</th>
                            <th class="p-4 font-semibold">Jumlah Produk</th>
                            <th class="p-4 font-semibold">Tanggal Dibuat</th>
                            <th class="p-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($categories as $i => $category)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-sm">
                                        {{ strtoupper(substr($category->nama, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-gray-800 text-sm">{{ $category->nama }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium {{ $category->products_count > 0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $category->products_count }} produk
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $category->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <button @click="showEditModal = true; editId = {{ $category->id }}; editNama = '{{ addslashes($category->nama) }}'" 
                                        class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                         Edit
                                    </button>
                                    <form action="{{ route('admin.kategori.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ addslashes($category->nama) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                             Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ============================================ --}}
    {{-- CREATE KATEGORI MODAL --}}
    {{-- ============================================ --}}
    <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showCreateModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showCreateModal = false"></div>
            <div x-show="showCreateModal" x-transition class="relative bg-white rounded-xl shadow-xl max-w-md w-full z-10">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"> Tambah Kategori Baru</h3>
                    <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" name="nama" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm" placeholder="Contoh: Wedding Cake, Donat, dll">
                        </div>
                        <div class="flex justify-end gap-3 pt-3 border-t">
                            <button type="button" @click="showCreateModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-purple-500 rounded-lg hover:bg-purple-600 transition cursor-pointer"> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- EDIT KATEGORI MODAL --}}
    {{-- ============================================ --}}
    <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showEditModal = false"></div>
            <div x-show="showEditModal" x-transition class="relative bg-white rounded-xl shadow-xl max-w-md w-full z-10">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"> Edit Kategori</h3>
                    <form :action="'/admin/kategori/' + editId" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" name="nama" x-model="editNama" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                        </div>
                        <div class="flex justify-end gap-3 pt-3 border-t">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-purple-500 rounded-lg hover:bg-purple-600 transition cursor-pointer"> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
