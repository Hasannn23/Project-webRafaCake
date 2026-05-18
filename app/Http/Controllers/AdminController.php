<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan Model Product sudah ada
use App\Models\Order;   // Pastikan Model Order sudah ada
use App\Models\User;    // Pastikan Model User sudah ada
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Ringkasan data untuk dashboard utama
        $totalProduk = Product::count();
        $pesananMasuk = Order::where('status', 'pending')->count();
        return view('admin.dashboard', compact('totalProduk', 'pesananMasuk'));
    }

    // --- KELOLA KATALOG (Poin #13) ---
    public function katalog()
    {
        $products = Product::all();
        return view('admin.katalog.index', compact('products'));
    }

    // --- MANAGEMENT USER (Poin #2) ---
    public function users()
    {
        // Hanya menampilkan member, bukan admin lain
        $users = User::where('role', 'member')->get();
        return view('admin.users.index', compact('users'));
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // --- KELOLA PESANAN (Poin #11, #14) ---
    public function pesanan()
    {
        // Pesanan yang statusnya belum selesai (pending/proses)
        $orders = Order::whereIn('status', ['pending', 'proses'])->latest()->get();
        return view('admin.pesanan.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status; // 'proses', 'tolak', atau 'selesai'
        $order->save();

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    // --- HISTORY PEMESANAN (Poin #12) ---
    public function history()
    {
        // Pesanan yang sudah 'selesai' atau 'done'
        $history = Order::where('status', 'selesai')->latest()->get();
        return view('admin.history.index', compact('history'));
    }

    // --- KELOLA REVIEW (Poin #15) ---
    public function review()
    {
        // Nanti kita buat Model Review
        return view('admin.review.index');
    }
}