<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-amber-800 leading-tight">
                {{ __('Dashboard Mitra Rafa Cake') }}
            </h2>
            <span class="bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wider">
                Gold Member
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="relative bg-gradient-to-r from-amber-500 to-orange-400 rounded-2xl shadow-xl overflow-hidden">
                <div class="absolute inset-0 bg-white/20 backdrop-blur-sm"></div>
                <!-- Decorative Circle -->
                <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full bg-white/10 blur-2xl"></div>
                
                <div class="relative p-8 sm:p-10 flex flex-col sm:flex-row items-center justify-between z-10">
                    <div>
                        <h3 class="text-3xl font-extrabold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}! 🍰</h3>
                        <p class="text-amber-50 text-lg">Siap untuk maniskan hari pelangganmu? Mari tingkatkan penjualan hari ini.</p>
                    </div>
                    <div class="mt-6 sm:mt-0">
                        <button class="bg-white text-orange-500 font-bold px-6 py-3 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition duration-300 ease-in-out cursor-pointer">
                            Buat Pesanan Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Pesanan (Bulan Ini)</p>
                            <h4 class="text-3xl font-bold text-gray-800 group-hover:text-amber-600 transition">124</h4>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-xl text-amber-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-emerald-500 font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            12.5%
                        </span>
                        <span class="text-gray-400 ml-2">dari bulan lalu</span>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Poin Loyalitas</p>
                            <h4 class="text-3xl font-bold text-gray-800 group-hover:text-amber-600 transition">2,450</h4>
                        </div>
                        <div class="p-3 bg-rose-50 rounded-xl text-rose-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                            <div class="bg-rose-400 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="text-gray-400 text-xs">550 poin lagi menuju tier Platinum</span>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Omset Bulan Ini</p>
                            <h4 class="text-3xl font-bold text-gray-800 group-hover:text-amber-600 transition">Rp 15.2M</h4>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-emerald-500 font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            8.2%
                        </span>
                        <span class="text-gray-400 ml-2">dari target Rp 20M</span>
                    </div>
                </div>
            </div>

            <!-- Content Grid: Recent Activity & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Orders -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                        <h4 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h4>
                        <a href="#" class="text-sm font-medium text-amber-600 hover:text-amber-800">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                                    <th class="p-4 font-semibold">ID Pesanan</th>
                                    <th class="p-4 font-semibold">Produk</th>
                                    <th class="p-4 font-semibold">Tanggal</th>
                                    <th class="p-4 font-semibold">Status</th>
                                    <th class="p-4 font-semibold">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-medium text-gray-900">#ORD-9921</td>
                                    <td class="p-4 text-gray-600">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-md bg-amber-100 flex items-center justify-center text-amber-600 font-bold mr-3">
                                                B
                                            </div>
                                            Black Forest Premium
                                        </div>
                                    </td>
                                    <td class="p-4 text-gray-500">20 Apr 2026</td>
                                    <td class="p-4">
                                        <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-medium">Selesai</span>
                                    </td>
                                    <td class="p-4 font-semibold text-gray-700">Rp 350.000</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-medium text-gray-900">#ORD-9922</td>
                                    <td class="p-4 text-gray-600">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-md bg-pink-100 flex items-center justify-center text-pink-600 font-bold mr-3">
                                                S
                                            </div>
                                            Strawberry Cheesecake
                                        </div>
                                    </td>
                                    <td class="p-4 text-gray-500">20 Apr 2026</td>
                                    <td class="p-4">
                                        <span class="bg-amber-100 text-amber-700 py-1 px-3 rounded-full text-xs font-medium">Diproses</span>
                                    </td>
                                    <td class="p-4 font-semibold text-gray-700">Rp 280.000</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-medium text-gray-900">#ORD-9923</td>
                                    <td class="p-4 text-gray-600">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-md bg-orange-100 flex items-center justify-center text-orange-600 font-bold mr-3">
                                                C
                                            </div>
                                            Choco Lava Set (12 pcs)
                                        </div>
                                    </td>
                                    <td class="p-4 text-gray-500">19 Apr 2026</td>
                                    <td class="p-4">
                                        <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-medium">Selesai</span>
                                    </td>
                                    <td class="p-4 font-semibold text-gray-700">Rp 450.000</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-medium text-gray-900">#ORD-9924</td>
                                    <td class="p-4 text-gray-600">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-md bg-purple-100 flex items-center justify-center text-purple-600 font-bold mr-3">
                                                R
                                            </div>
                                            Red Velvet Cake
                                        </div>
                                    </td>
                                    <td class="p-4 text-gray-500">18 Apr 2026</td>
                                    <td class="p-4">
                                        <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-medium">Dibatalkan</span>
                                    </td>
                                    <td class="p-4 font-semibold text-gray-700">Rp 300.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right Sidebar: Quick Actions & Promo -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-amber-50 hover:text-amber-600 transition group border border-transparent hover:border-amber-100 cursor-pointer">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-amber-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-amber-600">Pesanan Baru</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-orange-50 hover:text-orange-600 transition group border border-transparent hover:border-orange-100 cursor-pointer">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-orange-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-orange-600">Katalog</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition group border border-transparent hover:border-pink-100 cursor-pointer">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-pink-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-pink-600">Rewards</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition group border border-transparent hover:border-blue-100 cursor-pointer">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-blue-600">Bantuan</span>
                            </button>
                        </div>
                    </div>

                    <!-- Promo Banner -->
                    <div class="bg-gradient-to-br from-pink-500 to-rose-400 rounded-2xl shadow-md p-6 text-white relative overflow-hidden group">
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white opacity-10 rounded-full group-hover:scale-110 transition duration-500"></div>
                        <h4 class="text-lg font-bold mb-2 relative z-10">Promo Idul Fitri 🌙</h4>
                        <p class="text-pink-50 text-sm mb-4 relative z-10">Dapatkan diskon 15% untuk pemesanan Parcel Lebaran minimum 50 box.</p>
                        <button class="bg-white text-rose-500 text-sm font-bold px-4 py-2 rounded-full hover:shadow-lg transition z-10 relative cursor-pointer">
                            Klaim Promo
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
