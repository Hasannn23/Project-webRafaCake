<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input umum
        $request->validate([
            'nama_pemesan' => 'required',
            'nomor_wa' => 'required',
            'waktu_pengambilan' => 'required',
            'cart_data' => 'required',
            'total_harga' => 'required|numeric'
        ]);

        $cartItems = json_decode($request->cart_data, true);

        if (!$cartItems || empty($cartItems)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        // 3. Simpan ke Database
        $order = new \App\Models\Order();
        
        // Jika user tidak login tapi somehow masuk (misal form di homepage)
        if(auth()->check()) {
            $order->user_id = auth()->id();
        } else {
            // Jika Anda punya guest user ID atau biarkan null (pastikan user_id nullable di migration)
            // Namun migration saat ini `user_id` tidak nullable dan constrained.
            // Kita asumsikan middleware web memaksa auth atau kita set default 1 (admin/guest record).
            // Middleware di routes/web.php untuk order.store adalah 'auth', jadi aman.
            $order->user_id = auth()->id(); 
        }
        
        $order->nama_pemesan = $request->nama_pemesan;
        $order->nomor_wa = $request->nomor_wa;
        $order->waktu_pengambilan = $request->waktu_pengambilan;
        
        // Default nilai untuk field yang dihilangkan dari form agar tidak error database
        $order->distribusi = 'ambil_sendiri';
        $order->metode_pembayaran = 'transfer';
        $order->total_harga = $request->total_harga;
        
        // Simpan data keranjang ke kolom JSON
        $order->detail_tambahan = $cartItems; 

        $order->save();

        // 4. Redirect ke Pesanan Saya (Dashboard)
        // Kita tidak langsung ke WA sekarang, melainkan ke dashboard, lalu ada tombol WA di sana
        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dibuat! Silakan klik tombol WhatsApp untuk konfirmasi ke admin.');
    }
}
