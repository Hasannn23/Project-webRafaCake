<x-app-layout> 
    <div class="py-12 bg-white" x-data="shoppingCart()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <section id="produk" class="py-20 bg-pink-50 rounded-3xl" x-data="{ selectedCategory: 'Semua' }">
                <div class="max-w-7xl mx-auto px-6">
                    
                    <!-- Filter Kategori -->
                    <div class="mb-10 overflow-x-auto pb-4 hide-scrollbar">
                        <div class="flex gap-4 min-w-max">
                            @php
                                $categories = [
                                    'Semua',
                                    'Wedding cake 3 susun',
                                    'Cake potong',
                                    'Pizza',
                                    'Aneka Roti tepakan',
                                    'Aneka bolu medium',
                                    'Aneka Bolu pisang',
                                    'Aneka bolu jadul',
                                    'Aneka dessert',
                                    'Roti',
                                    'Cupcakes butterkrim size mini',
                                    'Cupcake ukuran standar',
                                    'Cake layer panjang',
                                    'Cake decor full butter krim'
                                ];
                            @endphp
                            @foreach($categories as $category)
                                <button type="button" 
                                        @click="selectedCategory = '{{ $category }}'"
                                        :class="selectedCategory === '{{ $category }}' ? 'bg-rafa-dark-pink text-white shadow-md' : 'bg-white text-gray-700 hover:bg-pink-100 shadow-sm'"
                                        class="px-6 py-2 rounded-full font-bold transition whitespace-nowrap cursor-pointer">
                                    {{ $category }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Grid Produk -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($products as $product)
                        <div x-show="selectedCategory === 'Semua' || selectedCategory === '{{ addslashes($product->kategori) }}'"
                             x-transition
                             class="bg-white rounded-2xl shadow-lg overflow-hidden border border-pink-50 hover:shadow-2xl transition duration-300 flex flex-col" style="display: none;">
                            <img src="{{ asset('storage/' . $product->gambar) }}" class="w-full h-56 object-cover" alt="{{ $product->nama_kue }}">
                            
                            <div class="p-6 flex flex-col flex-grow">
                                <span class="text-xs font-bold uppercase tracking-wider text-rafa-dark-pink bg-rafa-pink-100 px-3 py-1 rounded-full w-max">
                                    {{ $product->kategori }}
                                </span>
                                <h3 class="mt-3 text-xl font-bold text-gray-900">{{ $product->nama_kue }}</h3>
                                <p class="mt-2 text-gray-600 text-sm line-clamp-2 flex-grow">{{ $product->deskripsi }}</p>
                                
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-2xl font-bold text-rafa-dark-pink">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                </div>

                                <div class="mt-6">
                                    @auth
                                        @if(auth()->user()->role == 'member' || auth()->user()->role == 'user' || auth()->user()->usertype == 'user' || !isset(auth()->user()->role))
                                            <button type="button" @click="addToCart({{ $product->id }}, '{{ addslashes($product->nama_kue) }}', {{ $product->harga }}, '{{ asset('storage/' . $product->gambar) }}')" 
                                                    class="w-full bg-rafa-dark-pink hover:bg-pink-700 text-white font-bold py-3 rounded-xl transition flex justify-center items-center gap-2 cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                Tambah ke Keranjang
                                            </button>
                                        @else
                                            <a href="/admin/products" class="block text-center w-full bg-gray-800 text-white py-3 rounded-xl">Kelola Produk</a>
                                        @endif
                                    @endauth

                                    @guest
                                        <a href="{{ route('login') }}" 
                                        class="block text-center w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition">
                                            Login untuk Pesan
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

        <!-- Floating Cart Button -->
        <button @click="isCartOpen = true" class="fixed bottom-8 right-8 bg-rafa-dark-pink text-white p-4 rounded-full shadow-2xl hover:bg-pink-700 transition z-50 flex items-center justify-center cursor-pointer hover:scale-105 active:scale-95 duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span x-show="cartItemCount > 0" x-text="cartItemCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full border-2 border-white"></span>
        </button>

        <!-- Cart Drawer -->
        <div x-show="isCartOpen" 
             class="fixed inset-0 z-[100] overflow-hidden" 
             aria-labelledby="slide-over-title" 
             role="dialog" 
             aria-modal="true"
             style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <!-- Background overlay -->
                <div x-show="isCartOpen"
                     x-transition:enter="ease-in-out duration-500" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in-out duration-500" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" 
                     @click="isCartOpen = false"></div>

                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="isCartOpen"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                         x-transition:enter-start="translate-x-full" 
                         x-transition:enter-end="translate-x-0" 
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                         x-transition:leave-start="translate-x-0" 
                         x-transition:leave-end="translate-x-full" 
                         class="pointer-events-auto w-screen max-w-md">
                        
                        <div class="flex h-full flex-col bg-white shadow-xl">
                            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-xl font-bold text-gray-900" id="slide-over-title">Keranjang Belanja</h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500 cursor-pointer" @click="isCartOpen = false">
                                            <span class="absolute -inset-0.5"></span>
                                            <span class="sr-only">Tutup</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <div class="flow-root">
                                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                                            <template x-for="item in cart" :key="item.id">
                                                <li class="flex py-6">
                                                    <div class="flex items-center h-5 mr-4 mt-8">
                                                        <input :id="'item-' + item.id" type="checkbox" x-model="item.selected" @change="saveCart()" class="w-5 h-5 text-pink-600 bg-gray-100 border-gray-300 rounded focus:ring-pink-500 cursor-pointer">
                                                    </div>
                                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                        <img :src="item.image" :alt="item.name" class="h-full w-full object-cover object-center">
                                                    </div>

                                                    <div class="ml-4 flex flex-1 flex-col">
                                                        <div>
                                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                                <h3 x-text="item.name"></h3>
                                                                <p class="ml-4 font-bold text-rafa-dark-pink" x-text="'Rp ' + (item.price * item.quantity).toLocaleString('id-ID')"></p>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-1 items-end justify-between text-sm">
                                                            <div class="flex items-center border border-gray-300 rounded-md">
                                                                <button type="button" @click="updateQuantity(item.id, item.quantity - 1)" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-md font-bold cursor-pointer">-</button>
                                                                <span class="px-3 py-1 border-x border-gray-300 font-semibold" x-text="item.quantity"></span>
                                                                <button type="button" @click="updateQuantity(item.id, item.quantity + 1)" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-md font-bold cursor-pointer">+</button>
                                                            </div>

                                                            <div class="flex">
                                                                <button type="button" @click="removeFromCart(item.id)" class="font-medium text-red-500 hover:text-red-700 cursor-pointer">Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </template>
                                            <li x-show="cart.length === 0" class="py-12 text-center text-gray-500 flex flex-col items-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                <p>Keranjang kamu masih kosong.</p>
                                                <button @click="isCartOpen = false" class="mt-4 text-rafa-dark-pink font-semibold hover:underline">Belanja sekarang</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 px-4 py-6 sm:px-6 bg-gray-50">
                                <div class="flex justify-between text-base font-bold text-gray-900 mb-4">
                                    <p>Total Harga (<span x-text="selectedItems.length"></span> item)</p>
                                    <p class="text-rafa-dark-pink text-xl" x-text="'Rp ' + selectedTotal.toLocaleString('id-ID')"></p>
                                </div>
                                
                                <!-- Form to submit to OrderController -->
                                <form action="{{ route('order.store') }}" method="POST" id="checkout-form" @submit="submitOrder">
                                    @csrf
                                    <!-- We use a hidden input for cart data -->
                                    <input type="hidden" name="cart_data" :value="JSON.stringify(selectedItems)">
                                    <input type="hidden" name="total_harga" :value="selectedTotal">
                                    
                                    <div class="mt-4 space-y-4 text-left">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                            <input type="text" name="nama_pemesan" value="{{ auth()->check() ? auth()->user()->name : '' }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                                            <input type="text" name="nomor_wa" required placeholder="Contoh: 08123456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Pengambilan/Kirim</label>
                                            <input type="datetime-local" name="waktu_pengambilan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm">
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <button type="submit" 
                                                :disabled="selectedItems.length === 0"
                                                :class="{'opacity-50 cursor-not-allowed': selectedItems.length === 0}"
                                                class="flex w-full items-center justify-center rounded-xl border border-transparent bg-green-500 px-6 py-4 text-base font-bold text-white shadow-md hover:bg-green-600 hover:shadow-lg transition cursor-pointer gap-2">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                            Pesan Sekarang (WhatsApp)
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Memanggil bagian Tentang Kami -->
    @include('partials.about')
    <x-footer-contact />

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('shoppingCart', () => ({
                isCartOpen: false,
                cart: JSON.parse(localStorage.getItem('rafa_cart')) || [],
                
                get cartItemCount() {
                    return this.cart.reduce((total, item) => total + item.quantity, 0);
                },
                
                get selectedItems() {
                    return this.cart.filter(item => item.selected);
                },
                
                get selectedTotal() {
                    return this.selectedItems.reduce((total, item) => total + (item.price * item.quantity), 0);
                },
                
                saveCart() {
                    localStorage.setItem('rafa_cart', JSON.stringify(this.cart));
                },
                
                addToCart(id, name, price, image) {
                    const existingItem = this.cart.find(item => item.id === id);
                    if (existingItem) {
                        existingItem.quantity += 1;
                    } else {
                        this.cart.push({
                            id: id,
                            name: name,
                            price: price,
                            image: image,
                            quantity: 1,
                            selected: true
                        });
                    }
                    this.saveCart();
                    this.isCartOpen = true; // Buka keranjang saat ditambah
                },
                
                updateQuantity(id, newQuantity) {
                    if (newQuantity < 1) return;
                    const item = this.cart.find(item => item.id === id);
                    if (item) {
                        item.quantity = newQuantity;
                        this.saveCart();
                    }
                },
                
                removeFromCart(id) {
                    this.cart = this.cart.filter(item => item.id !== id);
                    this.saveCart();
                },

                submitOrder(e) {
                    if (this.selectedItems.length === 0) {
                        e.preventDefault();
                        alert('Pilih setidaknya satu produk untuk dipesan.');
                        return false;
                    }
                    
                    // Kita bisa menghapus item yang sudah dipesan dari keranjang setelah berhasil (opsional)
                    // localStorage.removeItem('rafa_cart'); 
                    // Wait, removing here might be too early if form validation fails. Let backend handle redirect to WA.
                    return true;
                }
            }));
        });
    </script>
</x-app-layout>