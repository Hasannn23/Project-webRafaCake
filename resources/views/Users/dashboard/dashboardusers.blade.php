<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openDetail: false, detailData: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Clear Cart If Coming From Success Checkout -->
            @if(session('success'))
                <script>
                    localStorage.removeItem('rafa_cart');
                </script>
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($orders->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-500 italic text-lg">Kamu belum pernah memesan. Yuk liat produk!</p>
                        <a href="/" class="mt-4 inline-block text-rafa-dark-pink font-bold hover:underline">Lihat Produk →</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pesan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ringkasan Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Ambil/Kirim</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status & Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <strong>{{ $order->nama_pemesan }}</strong><br>
                                        <span class="text-xs text-gray-500">
                                            @if($order->detail_tambahan && isset($order->detail_tambahan[0]['name']))
                                                <!-- Format Baru (Cart Array) -->
                                                @foreach($order->detail_tambahan as $item)
                                                    {{ $item['name'] }} ({{ $item['quantity'] }}x)@if(!$loop->last), @endif
                                                @endforeach
                                            @elseif($order->detail_tambahan)
                                                <!-- Format Lama (Key Value Object) -->
                                                @foreach($order->detail_tambahan as $key => $value)
                                                    @if(is_string($value) || is_numeric($value))
                                                        {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}@if(!$loop->last), @endif
                                                    @endif
                                                @endforeach
                                            @else
                                                Tidak ada detail tambahan.
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($order->waktu_pengambilan)->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-rafa-dark-pink">
                                        {{ $order->total_harga ? 'Rp '.number_format($order->total_harga, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-3">
                                            @if($order->status == 'pending')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                                
                                                @php
                                                    $waNumber = "6281284117673";
                                                    $waText = "Halo Admin Rafa Cake, saya mau konfirmasi pesanan:\n\n";
                                                    if ($order->detail_tambahan && isset($order->detail_tambahan[0]['name'])) {
                                                        foreach($order->detail_tambahan as $item) {
                                                            $waText .= "- " . $item['name'] . " (" . $item['quantity'] . "x) : Rp " . number_format($item['price'] * $item['quantity'], 0, ',', '.') . "\n";
                                                        }
                                                    }
                                                    $waText .= "\n*Total Belanja:* Rp " . number_format($order->total_harga, 0, ',', '.') . "\n";
                                                    $waText .= "\n*Informasi Pemesan:*\n";
                                                    $waText .= "- Nama: " . $order->nama_pemesan . "\n";
                                                    $waText .= "- No WA: " . $order->nomor_wa . "\n";
                                                    $waText .= "- Waktu Ambil/Kirim: " . \Carbon\Carbon::parse($order->waktu_pengambilan)->format('d M Y, H:i') . "\n";
                                                    $waText .= "\nMohon konfirmasinya ya Min. Terima kasih!";
                                                    
                                                    $waUrl = "https://wa.me/" . $waNumber . "?text=" . urlencode($waText);
                                                @endphp
                                                <a href="{{ $waUrl }}" target="_blank" class="text-xs bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded flex items-center gap-1 transition">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                                    WhatsApp
                                                </a>
                                            @elseif($order->status == 'selesai')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Selesai
                                                </span>
                                                <button @click='openDetail = true; detailData = @json($order)' class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded transition cursor-pointer">
                                                    Lihat Detail
                                                </button>
                                            @elseif($order->status == 'ditolak')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                                <button @click='openDetail = true; detailData = @json($order)' class="text-xs bg-gray-500 hover:bg-gray-600 text-white font-bold py-1 px-3 rounded transition cursor-pointer">
                                                    Lihat Detail
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detail Modal -->
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
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2" id="modal-title">
                                    Detail Pesanan <span x-text="detailData?.status === 'selesai' ? '(Selesai)' : '(Ditolak)'" class="text-sm font-bold text-gray-500"></span>
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
                                            <!-- Fallback untuk format lama (Object key-value) tidak didukung full di Alpine tanpa helper, jadi minimal kita tampilkan totalnya -->
                                        </ul>
                                    </div>

                                    <div class="border-t pt-3 mt-3 flex justify-between font-bold text-lg text-rafa-dark-pink">
                                        <span>Total:</span>
                                        <span x-text="detailData?.total_harga ? 'Rp ' + detailData.total_harga.toLocaleString('id-ID') : '-'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="openDetail = false" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>