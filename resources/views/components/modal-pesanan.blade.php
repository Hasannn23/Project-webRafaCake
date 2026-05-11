<div id="orderModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center p-4">
    
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col">
        
        <div class="bg-amber-500 p-5 flex justify-between items-center text-white">
            <div>
                <h3 class="font-bold text-xl" id="modalTitle">Form Pemesanan</h3>
                <p class="text-xs text-amber-100">Lengkapi data di bawah ini dengan benar.</p>
            </div>
            <button onclick="closeOrderModal()" class="text-3xl font-bold hover:text-red-200 transition">&times;</button>
        </div>

        <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Pemesan</label>
                    <input type="text" name="nama_pemesan" value="{{ auth()->user()->name ?? '' }}" class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input type="number" name="nomor_wa" placeholder="Contoh: 0812..." class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Waktu Pengambilan/Pengiriman</label>
                    <input type="datetime-local" name="waktu_pengambilan" class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        <option value="transfer">Transfer Bank (Dikirim via WA)</option>
                        <option value="cash">Bayar Tunai di Toko</option>
                    </select>
                </div>
            </div>

            <div class="mb-6 border-t border-gray-200 pt-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Distribusi Kue</label>
                <div class="flex gap-4 mb-3">
                    <label class="flex items-center">
                        <input type="radio" name="distribusi" value="ambil_sendiri" class="text-amber-500 focus:ring-amber-500" checked onchange="toggleAlamat(false)">
                        <span class="ml-2 text-sm">Ambil Sendiri ke Toko</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="distribusi" value="ojek" class="text-amber-500 focus:ring-amber-500" onchange="toggleAlamat(true)">
                        <span class="ml-2 text-sm">Dikirim (Ojek/Kurir)</span>
                    </label>
                </div>
                <textarea id="inputAlamat" name="alamat" rows="2" placeholder="Tulis alamat lengkap pengiriman..." class="hidden w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 mt-2"></textarea>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-6">
                <h4 class="text-sm font-bold text-amber-800 border-b border-amber-200 pb-2 mb-4">Detail Khusus Produk Ini:</h4>
                
                <div id="dynamicFields" class="space-y-4">
                    </div>
            </div>

            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300">
                Kirim Pesanan Sekarang
            </button>
            <p class="text-xs text-center text-gray-500 mt-3">Pesanan akan masuk ke Dashboard Anda dengan status PENDING.</p>
        </form>
    </div>
</div>

<script>
    // Fungsi menampilkan/menyembunyikan input alamat
    function toggleAlamat(show) {
        const alamat = document.getElementById('inputAlamat');
        if(show) {
            alamat.classList.remove('hidden');
            alamat.setAttribute('required', 'required');
        } else {
            alamat.classList.add('hidden');
            alamat.removeAttribute('required');
        }
    }

    // Fungsi membuka modal dan mengganti isi form sesuai kategori
    function openOrderModal(kategori, namaKue) {
        // Ganti judul modal
        document.getElementById('modalTitle').innerText = 'Pesan: ' + namaKue;
        
        // Ambil wadah untuk form dinamis
        const dynamicFields = document.getElementById('dynamicFields');
        dynamicFields.innerHTML = ''; // Kosongkan form sebelumnya
        
        // LOGIKA G-FORM: Isi form berbeda tiap kategori
        if (kategori === 'kue_custom') {
            dynamicFields.innerHTML = `
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Base Cake</label>
                    <select name="base_cake" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="Coklat Cake">Coklat Cake</option>
                        <option value="Red Velvet">Red Velvet</option>
                        <option value="Vanila">Vanila</option>
                        <option value="Lapis Malang">Lapis Malang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Ukuran Cake</label>
                    <input type="text" name="ukuran_cake" placeholder="Contoh: Diameter 20cm" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Tulisan di Kue</label>
                    <input type="text" name="tulisan_di_kue" placeholder="Contoh: Happy Birthday Budi" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Lilin</label>
                        <input type="text" name="lilin" placeholder="Contoh: Angka 17 / Lilin Batang" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Upload Foto Referensi</label>
                        <input type="file" name="foto_referensi" accept="image/*" class="w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Detail Request (Model/Warna/Tema)</label>
                    <textarea name="detail_request" rows="2" placeholder="Contoh: Tema Spiderman, warna dominan merah biru" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
            `;
        } 
        else if (kategori === 'donat') {
            dynamicFields.innerHTML = `
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Pilih Kategori Donat</label>
                    <select name="kategori_donat" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="Donat Karakter">Donat Karakter (Bentuk Hewan/Kartun)</option>
                        <option value="Donat Tulisan">Donat Tulisan (Huruf per donat)</option>
                        <option value="Donat Topping Premium">Donat Topping Premium</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Tulisan di Donat (Jika ada)</label>
                    <input type="text" name="tulisan_di_donat" placeholder="Contoh: HBD SAYANG" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Detail Request (Bentuk/Warna/Ornamen)</label>
                    <textarea name="detail_request" rows="2" placeholder="Contoh: Ornamen bunga mawar warna pink" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
            `;
        }
        else if (kategori === 'kue_kering') {
            dynamicFields.innerHTML = `
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Pilihan Toples</label>
                    <select name="pilihan_toples" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="Toples Standar 500gr">Toples Standar 500gr</option>
                        <option value="Toples Kaca Premium">Toples Kaca Premium (+Rp 20.000)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Catatan Tambahan</label>
                    <textarea name="catatan" rows="2" placeholder="Contoh: Tolong pita warna hijau" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
            `;
        }

        // Tampilkan modal (Hapus class 'hidden')
        document.getElementById('orderModal').classList.remove('hidden');
    }

    // Fungsi menutup modal
    function closeOrderModal() {
        document.getElementById('orderModal').classList.add('hidden');
    }
</script>