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
        ]);

        // 2. Ambil semua input selain data umum untuk dimasukkan ke JSON detail_tambahan
        // Ini akan menangkap otomatis: base_cake, ukuran, tulisan, dll sesuai kategori
        $inputDetail = $request->except([
            '_token', 'nama_pemesan', 'nomor_wa', 'waktu_pengambilan', 
            'distribusi', 'alamat', 'metode_pembayaran', 'foto_referensi'
        ]);

        // 3. Simpan ke Database
        $order = new \App\Models\Order();
        $order->user_id = auth()->id();
        $order->nama_pemesan = $request->nama_pemesan;
        $order->nomor_wa = $request->nomor_wa;
        $order->waktu_pengambilan = $request->waktu_pengambilan;
        $order->distribusi = $request->distribusi;
        $order->alamat = $request->alamat;
        $order->metode_pembayaran = $request->metode_pembayaran;
        
        // Simpan data unik kategori ke kolom JSON
        $order->detail_tambahan = $inputDetail; 

        if ($request->hasFile('foto_referensi')) {
            $order->foto_referensi = $request->file('foto_referensi')->store('referensi-kue', 'public');
        }

        $order->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dikirim! Tunggu konfirmasi Admin via WA.');
    }
}
