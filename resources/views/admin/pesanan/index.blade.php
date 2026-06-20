@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ 
    openDetail: false, 
    detailData: null,
    openTolak: false,
    tolakOrderId: null,
    tolakOrderData: null,
    alasanPenolakan: '',
    isSubmitting: false,
    
    async submitTolak() {
        if (!this.alasanPenolakan.trim()) {
            alert('Mohon isi alasan penolakan.');
            return;
        }
        
        this.isSubmitting = true;
        
        try {
            const url = `/admin/pesanan/${this.tolakOrderId}/status`;
            const response = await fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    status: 'ditolak',
                    alasan_penolakan: this.alasanPenolakan,
                }),
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Build WhatsApp message
                const order = this.tolakOrderData;
                let waText = `Halo ${order.nama_pemesan}, terima kasih sudah menghubungi Rafa Cake!\n\n`;
                waText += `Mohon maaf, pesanan kamu dengan detail berikut:\n\n`;
                waText += `DETAIL PESANAN\n`;
                waText += `Nomor Invoice: #INV-${String(order.id).padStart(5, '0')}\n\n`;
                
                if (order.detail_tambahan && Array.isArray(order.detail_tambahan) && order.detail_tambahan[0]?.name) {
                    order.detail_tambahan.forEach(item => {
                        const subtotal = item.price * item.quantity;
                        waText += `${item.name} (x${item.quantity}) = Rp ${subtotal.toLocaleString('id-ID')}\n\n`;
                    });
                }
                
                waText += `Total: Rp ${order.total_harga ? order.total_harga.toLocaleString('id-ID') : '0'}\n\n`;
                waText += `Sayangnya kami tidak dapat memproses pesanan ini.\n\n`;
                waText += `ALASAN PENOLAKAN:\n`;
                waText += `${this.alasanPenolakan}\n\n`;
                waText += `Kami mohon maaf atas ketidaknyamanannya. Silakan hubungi kami jika ada pertanyaan lebih lanjut. Terima kasih!`;
                
                // Format WA number
                let waNumber = order.nomor_wa.replace(/[^0-9]/g, '');
                if (waNumber.startsWith('0')) {
                    waNumber = '62' + waNumber.substring(1);
                }
                
                const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(waText)}`;
                window.open(waUrl, '_blank');
                
                // Reload page
                window.location.reload();
            } else {
                alert('Gagal menolak pesanan. Silakan coba lagi.');
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            this.isSubmitting = false;
        }
    }
}">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"> Kelola Pemesanan</h2>
            <p class="text-sm text-gray-500 mt-1">Pesanan masuk yang menunggu persetujuan</p>
        </div>
        <span class="bg-amber-100 text-amber-700 text-sm font-semibold px-3 py-1 rounded-full">
            {{ $orders->count() }} pesanan pending
        </span>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($orders->isEmpty())
            <div class="text-center py-12">
                
                <p class="text-gray-500 mt-3">Tidak ada pesanan yang menunggu persetujuan.</p>
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
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-sm font-medium text-gray-800">{{ $orders->firstItem() + $loop->index }}</td>
                            <td class="p-4">
                                <p class="font-semibold text-gray-800 text-sm">{{ $order->nama_pemesan }}</p>
                                <p class="text-xs text-gray-400">{{ $order->nomor_wa }}</p>
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
                            <td class="p-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="p-4 text-sm font-semibold text-gray-700">
                                {{ $order->waktu_pengambilan ? $order->waktu_pengambilan->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="p-4">
                                @if($order->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-semibold">Pending</span>
                                @elseif($order->status == 'disetujui')
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-semibold">Proses</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @php
                                        $waText = "Halo {$order->nama_pemesan}, terima kasih sudah berbelanja di Rafa Cake! \n\n";
                                        $waText .= "Berikut adalah rincian pesanan kamu:\n\n";
                                        $waText .= " DETAIL PEMESANAN\n";
                                        $waText .= "Nomor Invoice: #INV-" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . "\n\n";
                                        
                                        if ($order->detail_tambahan && isset($order->detail_tambahan[0]['name'])) {
                                            foreach($order->detail_tambahan as $item) {
                                                $subtotal = $item['price'] * $item['quantity'];
                                                $waText .= "{$item['name']} (x{$item['quantity']}) = Rp " . number_format($subtotal, 0, ',', '.') . "\n\n";
                                            }
                                        }
                                        
                                        $waText .= " TOTAL HARGA = Rp " . number_format($order->total_harga, 0, ',', '.') . "\n\n";
                                        
                                        $waText .= " IDENTITAS PEMBAYARAN\n";
                                        $waText .= "Silahkan transfer ke :\n\n";
                                        $waText .= "BCA: 8180129082 a.n suratno\n\n";
                                        $waText .= "Dana: 085624378677 a.n Eva\n\n";
                                        
                                        
                                        $waText .= " PANDUAN PEMBAYARAN\n\n";
                                        $waText .= "Pastikan nominal transfer sesuai persis dengan Total Harga di atas.\n\n";
                                        $waText .= "Jika sudah melakukan pembayaran, mohon konfirmasi dengan melampirkan Bukti Transfer (foto/screenshot).\n\n";
                                        $waText .= "Kalau ada kendala atau pertanyaan, langsung balas pesan ini aja ya. Terima kasih!";

                                        $cleanWaNumber = preg_replace('/[^0-9]/', '', $order->nomor_wa);
                                        // Ensure it starts with 62 instead of 0
                                        if (substr($cleanWaNumber, 0, 1) === '0') {
                                            $cleanWaNumber = '62' . substr($cleanWaNumber, 1);
                                        }
                                        $waUrl = "https://wa.me/" . $cleanWaNumber . "?text=" . urlencode($waText);
                                        $waUmumText = "Halo {$order->nama_pemesan}, terkait pesanan anda";
                                        $waUmumUrl = "https://wa.me/" . $cleanWaNumber . "?text=" . urlencode($waUmumText);
                                    @endphp

                                    {{-- Detail Button --}}
                                    <button @click='openDetail = true; detailData = @json($order)' class="text-xs bg-gray-500 hover:bg-gray-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                         Detail
                                    </button>
                                    {{-- Terima (Invoice WA) --}}
                                    @if($order->status == 'pending')
                                        <form action="{{ route('admin.pesanan.updateStatus', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" onclick="window.open('{{ $waUrl }}', '_blank')" class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                                 Terima
                                            </button>
                                        </form>
                                    @elseif($order->status == 'disetujui')
                                        <a href="{{ $waUmumUrl }}" target="_blank" class="inline-block text-xs bg-green-500 hover:bg-green-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                             Hubungi WA
                                        </a>
                                        <a href="{{ $waUrl }}" target="_blank" class="inline-block text-xs bg-purple-500 hover:bg-purple-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                             Invoice
                                        </a>
                                        <form action="{{ route('admin.pesanan.updateStatus', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer" onclick="return confirm('Pesanan selesai dan dipindah ke history #{{ $order->id }}?')">
                                                 Selesai
                                            </button>
                                        </form>
                                    @endif
                                    {{-- Tolak (membuka modal) --}}
                                    <button @click="openTolak = true; tolakOrderId = {{ $order->id }}; tolakOrderData = @js($order); alasanPenolakan = '';" class="text-xs bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                         Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    {{-- Detail Modal --}}
    <div x-show="openDetail" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="openDetail" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="openDetail = false"></div>
            <div x-show="openDetail" x-transition class="relative bg-white rounded-xl shadow-xl max-w-lg w-full z-10">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4"> Detail Pesanan</h3>
                    <div class="text-sm text-gray-600 space-y-3">
                        <p><strong>ID Pesanan:</strong> #<span x-text="detailData?.id"></span></p>
                        <p><strong>Nama:</strong> <span x-text="detailData?.nama_pemesan"></span></p>
                        <p><strong>No. WA:</strong> <span x-text="detailData?.nomor_wa"></span></p>
                        <p><strong>Waktu Ambil/Kirim:</strong> <span x-text="detailData?.waktu_pengambilan ? new Date(detailData.waktu_pengambilan).toLocaleString('id-ID') : '-'"></span></p>
                        
                        <div class="border-t pt-3 mt-3">
                            <p class="font-bold mb-2">Produk yang dipesan:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <template x-if="detailData?.detail_tambahan && Array.isArray(detailData.detail_tambahan) && detailData.detail_tambahan[0]?.name">
                                    <template x-for="item in detailData.detail_tambahan" :key="item.name">
                                        <li>
                                            <span x-text="item.name"></span> (x<span x-text="item.quantity"></span>) 
                                            — <span class="font-medium" x-text="'Rp ' + (item.price * item.quantity).toLocaleString('id-ID')"></span>
                                        </li>
                                    </template>
                                </template>
                            </ul>
                        </div>

                        <div class="border-t pt-3 mt-3 flex justify-between font-bold text-lg text-pink-600">
                            <span>Total:</span>
                            <span x-text="'Rp ' + (detailData?.total_harga ? detailData.total_harga.toLocaleString('id-ID') : '0')"></span>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end">
                    <button type="button" @click="openDetail = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tolak Pesanan --}}
    <div x-show="openTolak" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="openTolak" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="openTolak = false"></div>
            <div x-show="openTolak" x-transition class="relative bg-white rounded-xl shadow-xl max-w-lg w-full z-10">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-red-600 border-b pb-3 mb-4"> Tolak Pesanan</h3>
                    <div class="text-sm text-gray-600 space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-red-700 text-sm">
                                Anda akan <strong>menolak</strong> pesanan dari 
                                <strong x-text="tolakOrderData?.nama_pemesan"></strong>.
                                Setelah ditolak, pemesan akan otomatis dihubungi via WhatsApp.
                            </p>
                        </div>

                        <div>
                            <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700 mb-1">
                                Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                x-model="alasanPenolakan"
                                id="alasan_penolakan" 
                                rows="4" 
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm"
                                placeholder="Contoh: Stok bahan tidak mencukupi untuk pesanan ini..."
                            ></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end gap-3">
                    <button type="button" @click="openTolak = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                        Batal
                    </button>
                    <button 
                        type="button" 
                        @click="submitTolak()" 
                        :disabled="isSubmitting"
                        class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600 transition cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span x-show="!isSubmitting"> Tolak & Kirim WA</span>
                        <span x-show="isSubmitting"> Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
