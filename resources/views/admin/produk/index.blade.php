@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ showCreateModal: false, showDeleteModal: false, deleteId: null, deleteName: '' }">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"> Kelola Produk</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola semua produk kue Rafa Cake</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <!-- Filter Kategori -->
            <form method="GET" action="{{ route('admin.produk') }}" class="flex items-center gap-2">
                <select name="kategori" onchange="this.form.submit()"
                    class="text-sm rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white">
                    <option value=""> Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                @if(request('kategori'))
                    <a href="{{ route('admin.produk') }}" class="text-xs text-gray-500 hover:text-red-500 transition font-medium"> Reset</a>
                @endif
            </form>
            <a href="{{ route('admin.produk.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition flex items-center gap-2 text-sm">
                 Tambah Produk
            </a>
        </div>
    </div>

    <!-- Info filter aktif -->
    @if(request('kategori'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm px-4 py-2 rounded-lg flex items-center gap-2">
             Menampilkan produk kategori: <strong>{{ request('kategori') }}</strong>
            <span class="text-gray-400">—</span>
            <span>{{ $products->total() }} produk ditemukan</span>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($products->isEmpty())
            <div class="text-center py-12">
                
                <p class="text-gray-500 mt-3">
                    @if(request('kategori'))
                        Tidak ada produk di kategori "{{ request('kategori') }}".
                    @else
                        Belum ada produk. Tambahkan produk pertama!
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-4 font-semibold">#</th>
                            <th class="p-4 font-semibold">Gambar</th>
                            <th class="p-4 font-semibold">Nama Kue</th>
                            <th class="p-4 font-semibold">Kategori</th>
                            <th class="p-4 font-semibold">Harga</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($products as $i => $product)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-sm text-gray-600">{{ $products->firstItem() + $i }}</td>
                            <td class="p-4">
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_kue }}" class="w-14 h-14 object-cover rounded-lg border">
                            </td>
                            <td class="p-4">
                                <p class="font-semibold text-gray-800 text-sm">{{ $product->nama_kue }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($product->deskripsi, 40) }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium bg-blue-100 text-blue-700">
                                    {{ $product->kategori }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-semibold text-gray-800">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium {{ $product->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.produk.toggleStatus', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer {{ $product->is_available ? 'bg-amber-500 hover:bg-amber-600' : 'bg-emerald-500 hover:bg-emerald-600' }}">
                                            {{ $product->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.produk.edit', $product->id) }}" class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 px-3 rounded-lg transition">
                                         Edit
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->nama_kue }}?')">
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

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">
                            Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
                        </p>
                        <div class="flex items-center gap-2">
                            {{-- Previous --}}
                            @if($products->onFirstPage())
                                <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">← Prev</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">← Prev</a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if($page == $products->currentPage())
                                    <span class="px-3 py-1.5 text-sm font-bold text-white bg-pink-500 rounded-lg">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Next →</a>
                            @else
                                <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next →</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
