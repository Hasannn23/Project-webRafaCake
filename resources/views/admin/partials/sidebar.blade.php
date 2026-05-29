<aside class="w-64 bg-gradient-to-b from-pink-700 to-pink-900 text-white h-screen fixed shadow-xl z-50">
    <!-- Logo -->
    <div class="p-6 border-b border-pink-600">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <span class="text-2xl">🍰</span>
            <span class="text-xl font-bold tracking-wide">Rafa Cake</span>
        </a>
        <p class="text-pink-300 text-xs mt-1">Admin Panel</p>
    </div>

    <!-- Navigation -->
    <nav class="mt-4 px-3 space-y-1">
        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ $currentRoute == 'admin.dashboard' ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">📊</span>
            <span class="text-sm">Dashboard</span>
        </a>

        <!-- Kelola Katalog -->
        <a href="{{ route('admin.katalog') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.katalog') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">🍩</span>
            <span class="text-sm">Kelola Katalog</span>
        </a>

        <!-- Kelola User -->
        <a href="{{ route('admin.users') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.users') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">👥</span>
            <span class="text-sm">Kelola User</span>
        </a>

        <!-- Kelola Pesanan -->
        <a href="{{ route('admin.pesanan') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.pesanan') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">🛒</span>
            <span class="text-sm">Kelola Pemesanan</span>
        </a>

        <!-- History Pemesanan -->
        <a href="{{ route('admin.history') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.history') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">📜</span>
            <span class="text-sm">List History Pemesanan</span>
        </a>

        <!-- Kelola Review -->
        <a href="{{ route('admin.review') }}" 
           class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition duration-200 {{ str_starts_with($currentRoute, 'admin.review') ? 'bg-white/20 text-white font-semibold' : 'text-pink-200 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">⭐</span>
            <span class="text-sm">Kelola Review</span>
        </a>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 w-full p-4 border-t border-pink-600">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-pink-300 hover:text-white text-xs transition">
            <span>🌐</span>
            <span>Lihat Website</span>
        </a>
    </div>
</aside>