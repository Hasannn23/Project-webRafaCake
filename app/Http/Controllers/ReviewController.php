<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Simpan review baru untuk order yang sudah selesai.
     * Constraint: 1 review per order per user.
     */
    public function store(Request $request, Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Pastikan status order sudah selesai
        if ($order->status !== 'selesai') {
            return back()->with('error', 'Hanya pesanan yang sudah selesai yang bisa di-review.');
        }

        // Pastikan belum ada review untuk order ini
        if (Review::where('order_id', $order->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan review untuk pesanan ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:500',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan! Terima kasih atas feedback Anda.');
    }

    /**
     * Update review milik user.
     */
    public function update(Request $request, Review $review)
    {
        // Pastikan review milik user yang login
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit review ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:500',
        ]);

        $review->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Review berhasil diperbarui!');
    }

    /**
     * Hapus review milik user.
     */
    public function destroy(Review $review)
    {
        // Pastikan review milik user yang login
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus review ini.');
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }
}
