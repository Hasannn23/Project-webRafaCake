<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD UTAMA
    // ==========================================
    public function index()
    {
        $totalProduk = Product::count();
        $pesananMasuk = Order::where('status', 'pending')->count();
        $totalMember = User::where('role', 'member')->count();
        $totalReview = Review::where('is_deleted', 0)->count();
        $pesananSelesai = Order::where('status', 'selesai')->count();
        $totalKategori = Category::count();

        return view('admin.dashboardadmin', compact(
            'totalProduk', 'pesananMasuk', 'totalMember', 'totalReview', 'pesananSelesai', 'totalKategori'
        ));
    }

    // ==========================================
    // KELOLA KATALOG (CRUD Produk)
    // ==========================================
    public function katalog(Request $request)
    {
        $query = Product::latest();

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $products = $query->paginate(10)->appends($request->query());
        $kategoriList = Category::orderBy('nama')->pluck('nama');

        return view('admin.katalog.index', compact('products', 'kategoriList'));
    }

    public function createProduct()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.katalog.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'nama_kue' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori' => 'required|string',
            'is_promo' => 'nullable|boolean',
            'diskon' => 'nullable|integer|min:0|max:100',
        ]);

        $gambarPath = $request->file('gambar')->store('products', 'public');

        Product::create([
            'nama_kue' => $request->nama_kue,
            'slug' => Str::slug($request->nama_kue),
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
            'kategori' => $request->kategori,
            'is_promo' => $request->has('is_promo') ? true : false,
            'diskon' => $request->diskon ?? 0,
        ]);

        return redirect()->route('admin.katalog')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('nama')->get();
        return view('admin.katalog.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_kue' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori' => 'required|string',
            'is_promo' => 'nullable|boolean',
            'diskon' => 'nullable|integer|min:0|max:100',
        ]);

        $data = [
            'nama_kue' => $request->nama_kue,
            'slug' => Str::slug($request->nama_kue),
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'is_promo' => $request->has('is_promo') ? true : false,
            'diskon' => $request->diskon ?? 0,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.katalog')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }
        $product->delete();

        return redirect()->route('admin.katalog')->with('success', 'Produk berhasil dihapus!');
    }

    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_available = !$product->is_available;
        $product->save();

        $status = $product->is_available ? 'Tersedia' : 'Habis/Tidak Aktif';
        return back()->with('success', "Status produk {$product->nama_kue} berhasil diubah menjadi {$status}.");
    }

    // ==========================================
    // KELOLA USER (CRUD Member)
    // ==========================================
    public function users()
    {
        $users = User::withCount('orders')->where('role', 'member')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // ==========================================
    // KELOLA PEMESANAN (Terima / Tolak)
    // ==========================================
    public function pesanan()
    {
        $orders = Order::with('user')->whereIn('status', ['pending', 'disetujui'])->orderBy('waktu_pengambilan', 'asc')->paginate(10);
        return view('admin.pesanan.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,selesai',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string',
        ]);
        $order->status = $request->status;

        // Simpan alasan penolakan jika status ditolak
        if ($request->status === 'ditolak') {
            $order->alasan_penolakan = $request->alasan_penolakan;
        }

        $order->save();

        $statusText = match($request->status) {
            'disetujui' => 'diproses',
            'ditolak' => 'ditolak',
            'selesai' => 'diselesaikan',
            default => 'diperbarui',
        };

        // Return JSON jika request AJAX (untuk flow tolak)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pesanan berhasil {$statusText}.",
            ]);
        }

        return back()->with('success', "Pesanan berhasil {$statusText}.");
    }

    // ==========================================
    // HISTORY PEMESANAN (Pesanan Selesai)
    // ==========================================
    public function history(Request $request)
    {
        $query = Order::with('user')->whereIn('status', ['selesai', 'ditolak']);

        // Pencarian berdasarkan nama akun member
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $history = $query->latest()->paginate(10)->appends($request->query());
        return view('admin.history.index', compact('history'));
    }

    // ==========================================
    // KELOLA REVIEW
    // ==========================================
    public function review()
    {
        $reviews = Review::with(['user', 'order'])->where('is_deleted', 0)->latest()->paginate(10);
        return view('admin.review.index', compact('reviews'));
    }

    public function destroyReview($id)
    {
        $review = Review::findOrFail($id);
        $review->is_deleted = 1;
        $review->save();
        return back()->with('success', 'Review berhasil dihapus.');
    }

    // ==========================================
    // KELOLA KATEGORI (CRUD)
    // ==========================================
    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('nama')->paginate(10);
        return view('admin.kategori.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
        ]);

        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama,' . $category->id,
        ]);

        // Update juga nama kategori di semua produk yang menggunakan kategori ini
        Product::where('kategori', $category->nama)->update(['kategori' => $request->nama]);

        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        // Cek apakah masih ada produk yang menggunakan kategori ini
        $productCount = Product::where('kategori', $category->nama)->count();
        if ($productCount > 0) {
            return back()->with('error', "Kategori \"{$category->nama}\" tidak bisa dihapus karena masih digunakan oleh {$productCount} produk.");
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}