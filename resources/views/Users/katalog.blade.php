<x-app-layout> <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Container Utama (Harus relative dan overflow-hidden agar gambar tidak keluar dari border-radius) -->
        <!-- Header / Hero Section -->
        <div class="relative text-center mb-16 py-24 rounded-3xl overflow-hidden shadow-lg border border-pink-100">
            
            <!-- 1. Foto Bangunan (Background) -->
            <img src="{{ asset('images/BG1.png') }}" 
                alt="Bangunan Rafa Cake" 
                class="absolute inset-0 w-full h-full object-cover">

            <!-- 2. Layer Putih Opacity 20% (Tanpa Blur) -->
            <div class="absolute inset-0 bg-white/40"></div>
            


            <!-- 3. Konten Teks (Berada di atas layer) -->
            <div class="relative z-10">
                <h1 class="text-5xl md:text-6xl font-extrabold text-rafa-dark-pink mb-4 drop-shadow-md">
                    Rafa Cake
                </h1>
                <p class="text-xl md:text-2xl text-pink-700 font-semibold drop-shadow-sm">
                    Manisnya kualitas rumah produksi di setiap gigitan.
                </p>
            </div>
        </div>

        <section id="katalog" class="py-20 bg-pink-50">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b-2 border-rafa-dark-pink inline-block pb-2">Katalog</h2>
            
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-pink-50 hover:shadow-2xl transition duration-300">
                        <img src="{{ asset('storage/' . $product->gambar) }}" class="w-full h-56 object-cover" alt="{{ $product->nama_kue }}">
                        
                        <div class="p-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-rafa-dark-pink bg-rafa-pink-100 px-3 py-1 rounded-full">
                                {{ str_replace('_', ' ', $product->kategori) }}
                            </span>
                            <h3 class="mt-3 text-xl font-bold text-gray-900">{{ $product->nama_kue }}</h3>
                            <p class="mt-2 text-gray-600 text-sm line-clamp-2">{{ $product->deskripsi }}</p>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-2xl font-bold text-rafa-dark-pink">Rp {{ number_format($product->harga) }}</span>
                            </div>

                            <div class="mt-6">
                                @auth
                                    @if(auth()->user()->role == 'member')
                                        <button onclick="openOrderModal('{{ $product->kategori }}', '{{ $product->nama_kue }}')" 
                                                class="w-full bg-rafa-dark-pink hover:bg-pink-700 text-white font-bold py-3 rounded-xl transition">
                                            Pesan Sekarang (Web)
                                        </button>
                                    @else
                                        <a href="/admin/products" class="block text-center w-full bg-gray-800 text-white py-3 rounded-xl">Kelola Produk</a>
                                    @endif
                                @endauth

                                @guest
                                    <a href="https://wa.me/6281284117673?text=Halo Rafa Cake, saya mau pesan {{ $product->nama_kue }}" 
                                    class="block text-center w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition">
                                        Pesan via WhatsApp
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>  
        </section>
        </div>
    </div>
    <!-- Memanggil bagian Tentang Kami -->
    @include('partials.about')
    @include('components.modal-pesanan')
    <x-footer-contact />
</x-app-layout>