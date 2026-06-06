@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ openDetail: false, detailData: null }">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"> List History Pemesanan</h2>
            <p class="text-sm text-gray-500 mt-1">Pesanan yang sudah selesai / ditolak</p>
        </div>
        <span class="bg-green-100 text-green-700 text-sm font-semibold px-3 py-1 rounded-full">
            {{ $history->count() }} pesanan
        </span>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.history') }}" class="flex items-center gap-3">
            <div class="relative flex-1">
                
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama pemesan atau akun member..."
                    class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                >
            </div>
            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition text-sm cursor-pointer">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.history') }}" class="text-sm text-gray-500 hover:text-red-500 transition font-medium"> Reset</a>
            @endif
        </form>
    </div>

    <!-- Info pencarian aktif -->
    @if(request('search'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm px-4 py-2 rounded-lg flex items-center gap-2">
             Hasil pencarian: "<strong>{{ request('search') }}</strong>"
            <span class="text-gray-400">—</span>
            <span>{{ $history->count() }} pesanan ditemukan</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($history->isEmpty())
            <div class="text-center py-12">
                
                <p class="text-gray-500 mt-3">
                    @if(request('search'))
                        Tidak ditemukan pesanan untuk "{{ request('search') }}".
                    @else
                        Belum ada pesanan yang selesai.
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-4 font-semibold">No</th>
                            <th class="p-4 font-semibold">Pemesan</th>
                            <th class="p-4 font-semibold">Produk</th>
                            <th class="p-4 font-semibold">Total</th>
                            <th class="p-4 font-semibold">Tgl Pesan</th>
                            <th class="p-4 font-semibold">Tgl Ambil</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($history as $order)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-sm font-medium text-gray-800">{{ $history->firstItem() + $loop->index }}</td>
                            <td class="p-4">
                                <p class="font-semibold text-gray-800 text-sm">{{ $order->nama_pemesan }}</p>
                                <p class="text-xs text-gray-400">{{ $order->user->name ?? '-' }}</p>
                            </td>
                            <td class="p-4 text-sm text-gray-600">
                                @if($order->detail_tambahan && isset($order->detail_tambahan[0]['name']))
                                    @foreach($order->detail_tambahan as $item)
                                        <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full mr-1 mb-1">{{ $item['name'] }} ({{ $item['quantity'] }}x)</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm font-bold text-pink-600">
                                {{ $order->total_harga ? 'Rp '.number_format($order->total_harga, 0, ',', '.') : '-' }}
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-sm font-semibold text-gray-700">
                                {{ $order->waktu_pengambilan ? $order->waktu_pengambilan->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="p-4">
                                @if($order->status == 'selesai')
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-semibold">Selesai</span>
                                @elseif($order->status == 'ditolak')
                                    <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-semibold">Ditolak</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <button @click='openDetail = true; detailData = @json($order)' class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                     Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">
                {{ $history->links() }}
            </div>
        @endif
    </div>

    {{-- Detail Modal --}}
    <div x-show="openDetail" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="openDetail" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="openDetail = false"></div>
            <div x-show="openDetail" x-transition class="relative bg-white rounded-xl shadow-xl max-w-lg w-full z-10">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4"> Detail Pesanan</h3>
                    <div class="text-sm text-gray-600 space-y-3">
                        <p><strong>ID Pesanan:</strong> #<span x-text="detailData?.id"></span></p>
                        <p><strong>Nama Pemesan:</strong> <span x-text="detailData?.nama_pemesan"></span></p>
                        <p><strong>No. WA:</strong> <span x-text="detailData?.nomor_wa"></span></p>
                        <p><strong>Waktu Ambil:</strong> <span x-text="detailData?.waktu_pengambilan ? new Date(detailData.waktu_pengambilan).toLocaleString('id-ID') : '-'"></span></p>
                        <p><strong>Status:</strong> 
                            <span x-show="detailData?.status === 'selesai'" class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-semibold">Selesai</span>
                            <span x-show="detailData?.status === 'ditolak'" class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-semibold">Ditolak</span>
                        </p>

                        <div class="border-t pt-3">
                            <p class="font-bold mb-2">Produk yang dipesan:</p>
                            <template x-if="detailData?.detail_tambahan && Array.isArray(detailData.detail_tambahan) && detailData.detail_tambahan[0]?.name">
                                <ul class="list-disc pl-5 space-y-1">
                                    <template x-for="item in detailData.detail_tambahan" :key="item.name">
                                        <li>
                                            <span x-text="item.name"></span> (x<span x-text="item.quantity"></span>)
                                            — <span class="font-medium" x-text="'Rp ' + (item.price * item.quantity).toLocaleString('id-ID')"></span>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                        </div>

                        <div class="border-t pt-3 flex justify-between font-bold text-lg text-pink-600">
                            <span>Total:</span>
                            <span x-text="'Rp ' + (detailData?.total_harga ? detailData.total_harga.toLocaleString('id-ID') : '0')"></span>
                        </div>

                        {{-- Alasan Penolakan (hanya tampil untuk pesanan ditolak) --}}
                        <template x-if="detailData?.status === 'ditolak' && detailData?.alasan_penolakan">
                            <div class="border-t pt-3 mt-2">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="font-bold text-red-700 mb-1"> Alasan Penolakan:</p>
                                    <p class="text-red-600 text-sm" x-text="detailData.alasan_penolakan"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end">
                    <button @click="openDetail = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
