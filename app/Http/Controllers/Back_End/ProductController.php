<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {

        $products = Product::with(['store', 'variants'])->orderBy('id', 'asc')->paginate(10);

        return view('admin.produk.index', compact('products'));
    }

    /**
     * Menampilkan formulir untuk membuat produk baru.
     */
    public function create()
    {
        // Ambil daftar toko untuk dropdown
        $stores = Store::all(['id', 'name']);

        return view('admin.produk.create', compact('stores'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Dasar Produk
        $validatedData = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:150',
            'desc' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            // Pastikan Anda menangani upload file secara riil
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Upload Gambar (Logic Nyata)
        if ($request->hasFile('img')) {
            // Simpan di 'public/images/products'
            $validatedData['img'] = $request->file('img')->store('images/products', 'public');
        }

        try {
            // 3. Simpan Produk
            Product::create($validatedData);

            return redirect()->route('admin.produk.index')->with('success', 'Produk baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani error dan kembalikan user ke form dengan input lama
            return redirect()->back()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail produk dan variannya.
     * Menggunakan Route Model Binding.
     */
    public function show(Product $product)
    {
        // Muat relasi varian (variants) produk DAN TOKO (store)
        // PERBAIKAN: Menambahkan 'store' agar data Toko (nama dan alamat) tersedia di view 'show'.
        $product->load(['variants', 'store']);

        return view('admin.produk.show', compact('product'));
    }

    /**
     * Menampilkan formulir untuk mengedit produk.
     * Menggunakan Route Model Binding.
     */
    public function edit(Product $product)
    {
        $stores = Store::all(['id', 'name']);

        return view('admin.produk.edit', compact('product', 'stores'));
    }

    /**
     * Memperbarui produk yang ada di database.
     * Menggunakan Route Model Binding.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:150',
            'desc' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            // 'sometimes' digunakan agar validasi file hanya berjalan jika file diunggah
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Upload Gambar Baru (jika ada)
        if ($request->hasFile('img')) {
            // Hapus gambar lama
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }

            // Logika upload gambar baru (Nyata)
            $validatedData['img'] = $request->file('img')->store('images/products', 'public');
        }

        try {
            // 3. Update Produk
            $product->update($validatedData);

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus produk dari database.
     * Menggunakan Route Model Binding.
     */
    public function destroy(Product $product)
    {
        try {
            // Hapus gambar produk utama
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }
            
            // Produk akan dihapus. Varian akan terhapus jika diatur 'onDelete('cascade')' di migrasi.

            $product->delete();

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    // ===================================
    // KUSTOM UNTUK PRODUCT VARIANT (PERBAIKAN)
    // ===================================

    /**
     * Menyimpan variant baru untuk produk tertentu.
     */
    public function storeVariant(Request $request, Product $product)
    {
        // 1. VALIDASI DATA VARIANT BARU (TERIMA 'sizes' SEBAGAI STRING)
        $request->validate([
            'color' => 'required|string|max:100', // Ganti nullable menjadi required agar varian punya nama
            'price' => 'nullable|numeric|min:0',
            'sizes' => 'nullable|string', // PERBAIKAN: Menerima sebagai string yang dipisahkan koma
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. PERSIAPAN DATA
        $data = $request->only(['color', 'price']);

        // A. PEMROSESAN FIELD 'sizes' (SOLUSI KRITIS)
        if ($request->filled('sizes')) {
            // Pecah string koma menjadi array, bersihkan spasi berlebih, dan hapus nilai kosong
            $sizesArray = array_map('trim', explode(',', $request->sizes));
            $data['sizes'] = array_filter($sizesArray);
        } else {
            $data['sizes'] = null;
        }

        // B. PENANGANAN GAMBAR
        if ($request->hasFile('img')) {
            // Simpan gambar ke storage dan dapatkan path-nya
            $data['img'] = $request->file('img')->store('product_variants', 'public');
        } else {
            $data['img'] = null;
        }

        // 3. PROSES SIMPAN
        try {
            // Simpan varian yang terikat pada produk ini menggunakan relasi
            $product->variants()->create($data);

            return redirect()->route('admin.produk.show', $product)->with('success', 'Varian produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani error, tampilkan pesan agar mudah didiagnosis
            return redirect()->back()->with('error', 'Gagal menyimpan varian. Silakan periksa log server Anda. Detail: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus variant.
     * Menggunakan Route Model Binding untuk ProductVariant.
     */
    public function destroyVariant(ProductVariant $variant)
    {
        // Simpan ID produk sebelum varian dihapus untuk redirect
        $productId = $variant->product_id;

        try {
            // Hapus gambar varian dari storage
            if ($variant->img) {
                Storage::disk('public')->delete($variant->img);
            }

            $variant->delete();

            // Redirect kembali ke halaman detail produk
            return redirect()->route('admin.produk.show', $productId)->with('success', 'Varian berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus varian: ' . $e->getMessage());
        }
    }
}
