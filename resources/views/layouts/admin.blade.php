<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Rafa Cake</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex font-sans" x-data="{ sidebarOpen: true }">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Konten Utama -->
    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex justify-between items-center sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h2>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 font-semibold hover:text-red-700 transition cursor-pointer">
                        🚪 Logout
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

</body>
</html>