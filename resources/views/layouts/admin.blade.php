<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rafa Cake</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex font-sans">

    <!-- Memanggil Partial Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Konten Utama (Sebelah Kanan Sidebar) -->
    <div class="flex-1 ml-64 flex flex-col h-screen">
        
        <!-- Header Sederhana -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Halo, Admin!</h2>
            <button class="text-red-500 font-bold hover:text-red-700">Logout</button>
        </header>

        <!-- Area Konten Dinamis yang akan diisi oleh halaman lain -->
        <main class="p-6 flex-1 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</body>
</html>