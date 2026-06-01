<!-- Overlay for mobile -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-900/80 z-40 md:hidden" 
     @click="sidebarOpen = false" 
     style="display: none;"></div>

<aside class="w-64 bg-gradient-to-b from-pink-700 to-pink-900 text-white h-screen fixed shadow-xl z-50 transition-transform duration-300 transform md:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <!-- Logo and close button for mobile -->
    <div class="p-6 border-b border-pink-600 flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <span class="text-xl font-bold tracking-wide">Rafa Cake</span>
        </a>
        <button @click="sidebarOpen = false" class="md:hidden text-pink-300 hover:text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <p class="text-pink-300 text-xs mt-1 px-6">Admin Panel</p>

    <!-- Navigation -->
    <nav class="mt-4 px-3 space-y-1">
        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ $currentRoute == 'admin.dashboard' ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-sm">Dashboard</span>
        </a>

        <!-- Kelola Katalog -->
        <a href="{{ route('admin.katalog') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.katalog') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-sm">Kelola Katalog</span>
        </a>

        <!-- Kelola Kategori -->
        <a href="{{ route('admin.kategori') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.kategori') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-sm">Kelola Kategori</span>
        </a>

        <!-- Kelola User -->
        <a href="{{ route('admin.users') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.users') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-sm">Kelola User</span>
        </a>

        <!-- Kelola Pesanan -->
        <a href="{{ route('admin.pesanan') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.pesanan') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-sm">Kelola Pemesanan</span>
        </a>

        <!-- History Pemesanan -->
        <a href="{{ route('admin.history') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.history') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-sm">List History Pemesanan</span>
        </a>

        <!-- Kelola Review -->
        <a href="{{ route('admin.review') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.review') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-sm">Kelola Review</span>
        </a>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 w-full p-4 border-t border-pink-600">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-pink-300 hover:text-white text-xs transition">
            <span>Lihat Website</span>
        </a>
    </div>
</aside>