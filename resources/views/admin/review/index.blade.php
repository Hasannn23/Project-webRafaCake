@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ openDetail: false, detailData: null }">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">⭐ Kelola Review</h2>
            <p class="text-sm text-gray-500 mt-1">Semua review dari member yang telah menyelesaikan pesanan</p>
        </div>
        <span class="bg-emerald-100 text-emerald-700 text-sm font-semibold px-3 py-1 rounded-full">
            {{ $reviews->count() }} review
        </span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($reviews->isEmpty())
            <div class="text-center py-12">
                <span class="text-4xl">💬</span>
                <p class="text-gray-500 mt-3">Belum ada review dari member.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-4 font-semibold">#</th>
                            <th class="p-4 font-semibold">User</th>
                            <th class="p-4 font-semibold">Order ID</th>
                            <th class="p-4 font-semibold">Rating</th>
                            <th class="p-4 font-semibold">Komentar</th>
                            <th class="p-4 font-semibold">Tanggal</th>
                            <th class="p-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($reviews as $i => $review)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-bold text-xs">
                                        {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-gray-800 text-sm">{{ $review->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-gray-600">#{{ $review->order_id }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-0.5">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="text-sm">{{ $s <= $review->rating ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                            </td>
                            <td class="p-4 text-sm text-gray-600 max-w-xs">
                                <p class="truncate">{{ $review->komentar }}</p>
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    <button type="button" @click='openDetail = true; detailData = @json($review->order)' class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                        👁️ Detail
                                    </button>
                                    <form action="{{ route('admin.review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                            🗑️ Hapus
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

    {{-- DETAIL MODAL --}}
    <div x-show="openDetail" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openDetail" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openDetail = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="openDetail" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2" id="modal-title">
                                Detail Pesanan
                            </h3>
                            
                            <div class="mt-4 text-sm text-gray-600 space-y-3">
                                <p><strong>Nama:</strong> <span x-text="detailData?.nama_pemesan"></span></p>
                                <p><strong>No. WA:</strong> <span x-text="detailData?.nomor_wa"></span></p>
                                <p><strong>Waktu Ambil/Kirim:</strong> <span x-text="detailData ? new Date(detailData.waktu_pengambilan).toLocaleString('id-ID') : ''"></span></p>
                                
                                <div class="border-t pt-3 mt-3">
                                    <p class="font-bold mb-2">Produk yang dipesan:</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <template x-if="detailData?.detail_tambahan && Array.isArray(detailData.detail_tambahan) && detailData.detail_tambahan[0]?.name">
                                            <template x-for="item in detailData.detail_tambahan" :key="item.name">
                                                <li><span x-text="item.name"></span> (<span x-text="item.quantity"></span>x)</li>
                                            </template>
                                        </template>
                                    </ul>
                                </div>

                                <div class="border-t pt-3 mt-3 flex justify-between font-bold text-lg text-emerald-600">
                                    <span>Total:</span>
                                    <span x-text="detailData?.total_harga ? 'Rp ' + detailData.total_harga.toLocaleString('id-ID') : '-'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="openDetail = false" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
