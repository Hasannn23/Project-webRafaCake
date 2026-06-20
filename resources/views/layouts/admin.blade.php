<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rafa Cake - Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex font-sans" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Konten Utama -->
    <div class="flex-1 md:ml-64 flex flex-col min-h-screen w-full transition-all duration-300">
        
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-4 md:px-6 py-4 flex justify-between items-center sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h2 class="text-lg font-semibold text-gray-800 hidden sm:block">Halo, {{ Auth::user()->name }}!</h2>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500 hidden sm:block">{{ now()->format('d M Y') }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 font-semibold hover:text-red-700 transition cursor-pointer">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Area Konten -->
        <main class="p-6 flex-1 overflow-y-auto">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Script Maintain Scroll Position -->
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
            const path = window.location.pathname;
            const scrollpos = sessionStorage.getItem('scrollpos_' + path);
            if (scrollpos) {
                setTimeout(() => {
                    window.scrollTo(0, parseInt(scrollpos));
                    let mainEl = document.querySelector('main');
                    if(mainEl) mainEl.scrollTop = parseInt(scrollpos);
                }, 50);
            }
        });

        window.addEventListener("beforeunload", function() {
            const path = window.location.pathname;
            let scrollpos = window.scrollY || document.documentElement.scrollTop;
            let mainEl = document.querySelector('main');
            if(mainEl && mainEl.scrollTop > 0) {
                 scrollpos = mainEl.scrollTop;
            }
            sessionStorage.setItem('scrollpos_' + path, scrollpos);
        });
    </script>
</body>
</html>