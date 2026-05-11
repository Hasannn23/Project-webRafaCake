<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blueprint Sistem & Prototipe Web Rafa Cake</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #faf7f2; color: #4a3f35; }
        .bg-brand-primary { background-color: #d4a373; }
        .text-brand-primary { color: #d4a373; }
        .bg-brand-secondary { background-color: #faedcd; }
        .border-brand { border-color: #d4a373; }
        .btn-brand { background-color: #d4a373; color: white; transition: all 0.3s; }
        .btn-brand:hover { background-color: #bc8a5f; }
        
        .chart-container {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            height: 300px;
            max-height: 400px;
        }
        @media (min-width: 768px) {
            .chart-container {
                height: 350px;
            }
        }
    </style>
    <!-- Chosen Palette: Warm Pastry (Cream #faf7f2, Soft Beige #faedcd, Caramel/Brand #d4a373, Dark Brown #4a3f35) -->
    <!-- Application Structure Plan: Aplikasi web ini dirancang sebagai 'Developer Blueprint & Interactive Prototype'. Terdiri dari 3 bagian utama: 1) Rekomendasi Arsitektur Database untuk menjawab pertanyaan user tentang langkah selanjutnya. 2) Prototipe UI Interaktif untuk mendemonstrasikan alur Vertical Scrolling, perbedaan guest/member, dan form pemesanan. 3) Dashboard Admin untuk memvisualisasikan fitur bank data (analytics) menggunakan Chart.js. Struktur ini dipilih agar developer dapat melihat logika backend dan simulasi frontend secara bersamaan dalam satu halaman. -->
    <!-- Visualization & Content Choices: 
        1. Skema Database -> Ditampilkan menggunakan Card HTML/CSS Grid. Goal: Mengorganisasi struktur tabel dengan jelas tanpa menggunakan SVG/Mermaid.
        2. Simulasi Guest vs Member -> Toggle Button (Vanilla JS). Goal: Mendemonstrasikan perbedaan interaksi CTA 'Pesan' (WhatsApp vs Form).
        3. Form Pemesanan (Gform style) -> HTML Form Modal. Goal: Memvisualisasikan input data terstruktur berdasarkan kategori (Kue Kering, Donat, Custom).
        4. Analitik Admin -> Bar Chart (Chart.js pada Canvas). Goal: Memvisualisasikan history pesanan member bulanan (sesuai poin kebutuhan #6). -->
    <!-- CONFIRMATION: NO SVG graphics used. NO Mermaid JS used. -->
</head>
<body class="antialiased flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span class="text-2xl">🍰</span>
                    <span class="font-bold text-xl text-[#4a3f35]">Rafa Cake <span class="text-sm font-normal text-gray-500">| Blueprint Sistem</span></span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <button onclick="switchTab('database')" class="tab-btn text-[#d4a373] border-b-2 border-[#d4a373] font-medium pb-1" id="tab-database">1. Skema Database</button>
                    <button onclick="switchTab('prototype')" class="tab-btn text-gray-500 hover:text-[#d4a373] font-medium pb-1" id="tab-prototype">2. Prototipe Frontend</button>
                    <button onclick="switchTab('admin')" class="tab-btn text-gray-500 hover:text-[#d4a373] font-medium pb-1" id="tab-admin">3. Dasbor Admin</button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow p-4 sm:p-8">
        
        <div id="section-database" class="max-w-7xl mx-auto block animate-fade-in">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2">Langkah Selanjutnya: Arsitektur Database</h1>
                <p class="text-gray-600">Halo! Berdasarkan analisis kebutuhan Rafa Cake (actors, pemesanan member via web, history, review, dll), dan karena Anda sudah menyiapkan tabel `users` dengan kolom `role`, ini adalah <strong>tabel-tabel selanjutnya</strong> yang wajib Anda buat (Migration & Model di Laravel):</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-3 border-b pb-2 flex items-center justify-between">
                        <span>1. tabel <code class="text-brand-primary">categories</code></span>
                        <span>📁</span>
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Untuk membedakan form input (Kue Kering, Donat, Custom).</p>
                    <ul class="text-sm space-y-2 font-mono text-gray-700 bg-gray-50 p-3 rounded">
                        <li>id (PK)</li>
                        <li>name (string)</li>
                        <li>slug (string)</li>
                        <li>timestamps</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-3 border-b pb-2 flex items-center justify-between">
                        <span>2. tabel <code class="text-brand-primary">products</code></span>
                        <span>🎂</span>
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Menyimpan katalog kue, harga, dan promo.</p>
                    <ul class="text-sm space-y-2 font-mono text-gray-700 bg-gray-50 p-3 rounded">
                        <li>id (PK)</li>
                        <li>category_id (FK)</li>
                        <li>name (string)</li>
                        <li>description (text)</li>
                        <li>price (integer)</li>
                        <li>image (string)</li>
                        <li>is_featured (boolean)</li>
                        <li>discount_percent (integer)</li>
                        <li>timestamps</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-[#d4a373]">
                    <h3 class="text-lg font-bold mb-3 border-b pb-2 flex items-center justify-between">
                        <span>3. tabel <code class="text-brand-primary">orders</code></span>
                        <span>📝</span>
                    </h3>
                    <p class="text-sm text-gray-500 mb-4"><strong>Sangat Penting!</strong> Bank data pesanan khusus Member.</p>
                    <ul class="text-sm space-y-2 font-mono text-gray-700 bg-gray-50 p-3 rounded">
                        <li>id (PK)</li>
                        <li>user_id (FK -> member)</li>
                        <li>booking_date (date)</li>
                        <li>status (enum: pending, accepted, rejected)</li>
                        <li>custom_notes (text)</li>
                        <li>invoice_number (string)</li>
                        <li>timestamps</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-3 border-b pb-2 flex items-center justify-between">
                        <span>4. tabel <code class="text-brand-primary">order_items</code></span>
                        <span>🛍️</span>
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Menyimpan rincian produk apa saja yang dibeli dalam 1 pesanan.</p>
                    <ul class="text-sm space-y-2 font-mono text-gray-700 bg-gray-50 p-3 rounded">
                        <li>id (PK)</li>
                        <li>order_id (FK)</li>
                        <li>product_id (FK)</li>
                        <li>quantity (integer)</li>
                        <li>price_at_booking (integer)</li>
                        <li>timestamps</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-3 border-b pb-2 flex items-center justify-between">
                        <span>5. tabel <code class="text-brand-primary">reviews</code></span>
                        <span>⭐</span>
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Memberikan rating. Dikelola admin sebelum tampil.</p>
                    <ul class="text-sm space-y-2 font-mono text-gray-700 bg-gray-50 p-3 rounded">
                        <li>id (PK)</li>
                        <li>user_id (FK)</li>
                        <li>product_id (FK)</li>
                        <li>rating (integer 1-5)</li>
                        <li>comment (text)</li>
                        <li>is_visible (boolean, def: false)</li>
                        <li>timestamps</li>
                    </ul>
                </div>

                <div class="bg-[#d4a373] p-6 rounded-xl shadow-sm text-white flex flex-col justify-center">
                    <h3 class="text-xl font-bold mb-2">Selanjutnya: Relasi Model</h3>
                    <p class="text-sm mb-4">Di Laravel, pastikan membuat relasi:<br>User <code>hasMany</code> Orders.<br>Order <code>belongsTo</code> User.<br>Product <code>belongsTo</code> Category.</p>
                    <button onclick="switchTab('prototype')" class="bg-white text-[#d4a373] px-4 py-2 rounded font-bold hover:bg-gray-100 transition">Lihat Simulasi Frontend &#8594;</button>
                </div>

            </div>
        </div>

        
        <div id="section-prototype" class="max-w-4xl mx-auto hidden animate-fade-in">
            <div class="mb-6 flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-xl shadow-sm">
                <div>
                    <h2 class="text-xl font-bold">Simulasi Interaktif Web Rafa Cake</h2>
                    <p class="text-sm text-gray-500">Coba ubah peran (Aktor) untuk melihat perbedaan logika tombol 'Pesan'.</p>
                </div>
                <div class="mt-4 md:mt-0 flex bg-gray-100 p-1 rounded-lg">
                    <button id="role-guest" onclick="setRole('guest')" class="px-4 py-2 rounded-md text-sm font-semibold bg-white shadow-sm text-gray-800 transition">👤 Sebagai Guest</button>
                    <button id="role-member" onclick="setRole('member')" class="px-4 py-2 rounded-md text-sm font-semibold text-gray-500 hover:text-gray-800 transition">🟢 Sebagai Member</button>
                </div>
            </div>

            
            <div class="border-[8px] border-gray-800 rounded-3xl overflow-hidden h-[800px] bg-white relative flex flex-col shadow-2xl">
                
                <header class="bg-white p-4 flex justify-between items-center border-b sticky top-0 z-10">
                    <div class="font-bold text-[#d4a373] text-lg">🍰 Rafa Cake</div>
                    <div class="text-sm font-medium">
                        <span id="nav-login" class="text-gray-600">Login / Daftar</span>
                        <span id="nav-profile" class="hidden text-green-600">Halo, Budi (Member)</span>
                    </div>
                </header>

                
                <div class="overflow-y-auto flex-grow pb-20 scroll-smooth">
                    
                    <div class="bg-brand-secondary p-8 text-center">
                        <h1 class="text-3xl font-bold text-[#4a3f35] mb-2">Manisnya Setiap Momen</h1>
                        <p class="text-sm text-gray-600 mb-6">Rumah produksi kue premium untuk acara spesial Anda.</p>
                        <div class="inline-block bg-red-500 text-white px-4 py-1 rounded-full text-xs font-bold animate-pulse">PROMO: Diskon 20% Kue Kering!</div>
                    </div>

                    
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-4 border-b-2 border-[#d4a373] inline-block pb-1">Produk Unggulan Kami</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <div class="border rounded-xl p-4 flex flex-col justify-between hover:shadow-md transition">
                                <div>
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-4xl mb-3">🍩</div>
                                    <div class="text-xs text-[#d4a373] font-bold mb-1">Kategori: Donat</div>
                                    <h3 class="font-bold text-lg mb-1">Donat Tower Spesial</h3>
                                    <p class="text-xs text-gray-500 mb-2">Susunan 30 donat premium dengan berbagai topping. Cocok untuk ulang tahun.</p>
                                    <div class="font-bold text-lg">Rp 250.000</div>
                                </div>
                                <button onclick="handleOrder('Donat Tower Spesial', 'donat')" class="mt-4 w-full border border-[#d4a373] text-[#d4a373] font-bold py-2 rounded hover:bg-[#d4a373] hover:text-white transition">
                                    <span class="btn-text">Pesan Sekarang</span>
                                </button>
                            </div>

                            
                            <div class="border rounded-xl p-4 flex flex-col justify-between hover:shadow-md transition">
                                <div>
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-4xl mb-3">🎂</div>
                                    <div class="text-xs text-[#d4a373] font-bold mb-1">Kategori: Custom Kue</div>
                                    <h3 class="font-bold text-lg mb-1">Kue Pengantin Custom</h3>
                                    <p class="text-xs text-gray-500 mb-2">Desain sesuai keinginan. Ukuran mulai dari 2 tingkat. Silahkan konsultasi detail.</p>
                                    <div class="font-bold text-lg">Mulai Rp 500.000</div>
                                </div>
                                <button onclick="handleOrder('Kue Pengantin Custom', 'custom')" class="mt-4 w-full border border-[#d4a373] text-[#d4a373] font-bold py-2 rounded hover:bg-[#d4a373] hover:text-white transition">
                                    <span class="btn-text">Pesan Sekarang</span>
                                </button>
                            </div>

                            
                            <div class="border rounded-xl p-4 flex flex-col justify-between hover:shadow-md transition md:col-span-2">
                                <div>
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-4xl mb-3">🍪</div>
                                    <div class="text-xs text-red-500 font-bold mb-1">PROMO 20% | Kategori: Kue Kering</div>
                                    <h3 class="font-bold text-lg mb-1">Hampers Nastar Klasik</h3>
                                    <p class="text-xs text-gray-500 mb-2">Nastar full butter lumer di mulut. Isi 500gr.</p>
                                    <div class="flex gap-2 items-center">
                                        <div class="font-bold text-lg text-red-500">Rp 120.000</div>
                                        <div class="text-sm text-gray-400 line-through">Rp 150.000</div>
                                    </div>
                                </div>
                                <button onclick="handleOrder('Hampers Nastar Klasik', 'kering')" class="mt-4 w-full btn-brand font-bold py-2 rounded transition">
                                    <span class="btn-text">Pesan Promo Ini</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-gray-50 p-6 mt-4 text-center border-t">
                        <h2 class="font-bold text-lg mb-2">Ulasan Pelanggan</h2>
                        <div class="text-3xl text-yellow-400 mb-2">★★★★★</div>
                        <p class="italic text-sm text-gray-600">"Kue customnya persis seperti request, rasanya juga juara! Admin ramah."</p>
                        <p class="text-xs font-bold mt-2">- Siti (Member)</p>
                    </div>

                </div>
                
                
                <div id="wa-alert" class="absolute bottom-4 left-4 right-4 bg-green-500 text-white p-4 rounded-xl shadow-lg transform translate-y-[150%] transition duration-300 flex items-center gap-3">
                    <span class="text-2xl">📱</span>
                    <div>
                        <div class="font-bold text-sm">Dialihkan ke WhatsApp</div>
                        <div class="text-xs opacity-90">Karena Anda Guest, pesanan langsung diteruskan ke WA Admin.</div>
                    </div>
                </div>

                
                <div id="order-modal" class="absolute inset-0 bg-black/60 hidden flex-col justify-end z-20">
                    <div class="bg-white w-full rounded-t-2xl p-6 h-[85%] flex flex-col transform transition-transform duration-300 translate-y-full" id="order-modal-content">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h2 class="font-bold text-xl">Form Pemesanan (Member)</h2>
                            <button onclick="closeModal()" class="text-2xl text-gray-500 hover:text-red-500">&times;</button>
                        </div>
                        
                        <div class="overflow-y-auto flex-grow pb-4">
                            <p class="text-sm text-gray-500 mb-4">Hai Member! Data pesanan ini akan masuk ke database kami agar Anda bisa melihat riwayat nantinya.</p>
                            
                            <div class="bg-brand-secondary p-3 rounded mb-4">
                                <div class="text-xs text-gray-500">Produk Terpilih:</div>
                                <div class="font-bold" id="modal-product-name">Produk</div>
                            </div>

                            <form onsubmit="submitForm(event)" class="space-y-4">
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Tanggal Booking/Pengiriman</label>
                                    <input type="date" class="w-full border rounded p-2 text-sm focus:ring focus:ring-brand-primary" required>
                                </div>

                                
                                <div id="dynamic-form-fields" class="space-y-4 border-l-2 border-[#d4a373] pl-3">
                                    
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Catatan Tambahan (Opsional)</label>
                                    <textarea class="w-full border rounded p-2 text-sm focus:ring focus:ring-brand-primary" rows="2" placeholder="Contoh: Tolong pita warna biru"></textarea>
                                </div>

                                <div class="bg-yellow-50 p-3 rounded text-xs text-yellow-800 mb-4 border border-yellow-200">
                                    <strong>Info Pembayaran:</strong> Setelah submit, Admin akan meninjau pesanan Anda. Jika disanggupi, Invoice akan dikirim ke WhatsApp Anda untuk pembayaran.
                                </div>

                                <button type="submit" class="w-full btn-brand font-bold py-3 rounded-lg mt-2">Kirim Pesanan ke Database</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        
        <div id="section-admin" class="max-w-7xl mx-auto hidden animate-fade-in">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Dasbor Admin: Bank Data & Analitik</h2>
                <p class="text-gray-600">Sesuai kebutuhan (poin 6): <em>"Owner ingin inputan data yang dilakukan member masuk ke database untuk bank data agar owner bisa melihat pelanggan ini membeli kue berapa kali dll."</em></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg mb-4">Statistik Pesanan Member (Bulan Ini)</h3>
                    <div class="chart-container">
                        <canvas id="memberOrderChart"></canvas>
                    </div>
                    <p class="text-xs text-center text-gray-500 mt-4">Visualisasi ini mengambil data dari tabel <code>orders</code> yang terhubung dengan <code>users (member)</code>.</p>
                </div>

                
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-lg mb-4 flex items-center gap-2"><span>🔔</span> Pesanan Masuk (Butuh Review)</h3>
                        
                        <div class="border border-yellow-200 bg-yellow-50 rounded-lg p-3 mb-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded font-bold">Pending</span>
                                    <div class="font-bold mt-1">Budi (Member)</div>
                                    <div class="text-sm">Donat Tower Spesial</div>
                                    <div class="text-xs text-gray-500">Tgl: 28 Apr 2026</div>
                                </div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button onclick="acceptOrder()" class="bg-green-500 text-white text-xs px-3 py-1.5 rounded hover:bg-green-600">Terima & Kirim Invoice WA</button>
                                <button class="bg-red-500 text-white text-xs px-3 py-1.5 rounded hover:bg-red-600">Tolak</button>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-xs bg-gray-200 text-gray-800 px-2 py-0.5 rounded font-bold">Pending</span>
                                    <div class="font-bold mt-1">Siti (Member)</div>
                                    <div class="text-sm">Kue Custom</div>
                                    <div class="text-xs text-gray-500">Tgl: 30 Apr 2026</div>
                                </div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button class="bg-green-500 text-white text-xs px-3 py-1.5 rounded hover:bg-green-600">Terima & Kirim Invoice WA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        // --- Navigation Logic ---
        function switchTab(tabId) {
            // Hide all sections
            document.getElementById('section-database').classList.add('hidden');
            document.getElementById('section-prototype').classList.add('hidden');
            document.getElementById('section-admin').classList.add('hidden');
            
            // Reset tab styling
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('text-[#d4a373]', 'border-b-2', 'border-[#d4a373]');
                btn.classList.add('text-gray-500');
            });

            // Show selected section
            document.getElementById(`section-${tabId}`).classList.remove('hidden');
            
            // Highlight active tab
            const activeTab = document.getElementById(`tab-${tabId}`);
            activeTab.classList.remove('text-gray-500');
            activeTab.classList.add('text-[#d4a373]', 'border-b-2', 'border-[#d4a373]');

            // Render chart if admin tab is clicked and chart doesn't exist yet
            if(tabId === 'admin' && !window.chartInitialized) {
                initChart();
                window.chartInitialized = true;
            }
        }

        // --- Prototype Logic: Guest vs Member State ---
        let currentRole = 'guest'; // default state

        function setRole(role) {
            currentRole = role;
            
            const btnGuest = document.getElementById('role-guest');
            const btnMember = document.getElementById('role-member');
            const navLogin = document.getElementById('nav-login');
            const navProfile = document.getElementById('nav-profile');
            const actionTexts = document.querySelectorAll('.btn-text');

            if (role === 'guest') {
                btnGuest.classList.replace('text-gray-500', 'text-gray-800');
                btnGuest.classList.replace('hover:text-gray-800', 'bg-white');
                btnGuest.classList.add('shadow-sm');
                
                btnMember.classList.remove('bg-white', 'shadow-sm', 'text-gray-800');
                btnMember.classList.add('text-gray-500', 'hover:text-gray-800');

                navLogin.classList.remove('hidden');
                navProfile.classList.add('hidden');

                actionTexts.forEach(el => el.textContent = "Pesan (via WA)");
            } else {
                btnMember.classList.replace('text-gray-500', 'text-gray-800');
                btnMember.classList.replace('hover:text-gray-800', 'bg-white');
                btnMember.classList.add('shadow-sm');
                
                btnGuest.classList.remove('bg-white', 'shadow-sm', 'text-gray-800');
                btnGuest.classList.add('text-gray-500', 'hover:text-gray-800');

                navLogin.classList.add('hidden');
                navProfile.classList.remove('hidden');

                actionTexts.forEach(el => el.textContent = "Pesan (Isi Form)");
            }
        }

        function handleOrder(productName, category) {
            if (currentRole === 'guest') {
                // Show WhatsApp Alert
                const alertEl = document.getElementById('wa-alert');
                alertEl.classList.remove('translate-y-[150%]');
                setTimeout(() => {
                    alertEl.classList.add('translate-y-[150%]');
                }, 4000);
            } else {
                // Open Member Form Modal based on Category (Semacam GForm)
                document.getElementById('modal-product-name').textContent = productName;
                const dynamicFields = document.getElementById('dynamic-form-fields');
                dynamicFields.innerHTML = ''; // clear previous

                if(category === 'kering') {
                    dynamicFields.innerHTML = `
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Pilihan Toples (Form Khusus Kue Kering)</label>
                            <select class="w-full border rounded p-2 text-sm">
                                <option>Toples Kaca Premium (+Rp 20.000)</option>
                                <option>Toples Plastik Standar</option>
                            </select>
                        </div>
                    `;
                } else if(category === 'donat') {
                    dynamicFields.innerHTML = `
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tulisan di Coklat (Form Khusus Donat)</label>
                            <input type="text" class="w-full border rounded p-2 text-sm" placeholder="Contoh: Happy Birthday Budi">
                        </div>
                    `;
                } else if(category === 'custom') {
                    dynamicFields.innerHTML = `
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Referensi Desain (Form Khusus Custom)</label>
                            <input type="file" class="w-full border rounded p-1 text-sm bg-white">
                            <p class="text-[10px] mt-1 text-gray-500">Upload referensi gambar kue yang diinginkan</p>
                        </div>
                    `;
                }

                const modal = document.getElementById('order-modal');
                const modalContent = document.getElementById('order-modal-content');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalContent.classList.remove('translate-y-full');
                }, 10);
            }
        }

        function closeModal() {
            const modal = document.getElementById('order-modal');
            const modalContent = document.getElementById('order-modal-content');
            modalContent.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function submitForm(e) {
            e.preventDefault();
            alert("Data Pesanan berhasil masuk ke Database!\n\nStatus saat ini: PENDING.\nSilahkan tunggu Admin menyetujui dan mengirim Invoice ke WhatsApp Anda.");
            closeModal();
        }

        function acceptOrder() {
            alert("Pesanan Diterima di Database!\n\nSistem meng-generate Invoice dan membuka tab WhatsApp Web menuju nomor pemesan.");
        }

        // --- Admin Dashboard Logic (Chart.js) ---
        function initChart() {
            const ctx = document.getElementById('memberOrderChart').getContext('2d');
            
            // Mock Data for Analytics (Requirement 6: melihat pelanggan beli kue berapa kali)
            const data = {
                labels: ['Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Rina Marlina', 'Joko Susilo'],
                datasets: [{
                    label: 'Jumlah Transaksi Selesai',
                    data: [4, 3, 2, 5, 1],
                    backgroundColor: '#d4a373',
                    borderRadius: 4,
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Important for container sizing
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Pesanan Bulan Ini';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            ticks: {
                                callback: function(value) {
                                    const label = this.getLabelForValue(value);
                                    if (label.length > 16) {
                                        return label.substr(0, 16) + '...';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        }

        // Initialize state
        setRole('guest');
    </script>
    <x-footer-contact />
</body>
</html>