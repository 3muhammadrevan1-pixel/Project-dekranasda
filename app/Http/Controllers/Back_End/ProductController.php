<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk dengan paginasi 10 item per halaman.
     */
    public function index()
    {
        // Paginasi diatur di sini: paginate(10) akan membatasi hasil menjadi 10 per halaman.
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
     * Menyimpan produk baru ke database dan varian utama jika diperlukan.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Dasar Produk
        $validatedData = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:150',
            'desc' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100|in:Sepatu,Baju,None',
            'price' => 'nullable|numeric|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // VALIDASI KONDISIONAL UNTUK VARIAN UTAMA (Warna dan Ukuran)
            'color' => [
                // Warna wajib diisi jika Tipe adalah Sepatu, Baju, atau None (tapi bukan kosong)
                Rule::requiredIf(fn () => in_array($request->input('type'), ['Sepatu', 'Baju', 'None'])),
                'nullable',
                'string',
                'max:100',
            ],
            'sizes' => [
                // Ukuran wajib diisi jika Tipe adalah Sepatu atau Baju
                Rule::requiredIf(fn () => in_array($request->input('type'), ['Sepatu', 'Baju'])),
                'nullable',
                'string',
                // Validasi Regex untuk Sepatu (Hanya Angka, Koma)
                Rule::when($request->type === 'Sepatu', ['regex:/^[\d,]+$/', 'max:255']), 
                // Validasi Regex untuk Baju (Hanya Huruf, Angka, Spasi, Koma)
                Rule::when($request->type === 'Baju', ['regex:/^[\w\s,]+$/', 'max:255']),
            ],
        ]);

        // 2. Upload Gambar (Logic Nyata)
        $imgPath = null;
        if ($request->hasFile('img')) {
            // Simpan di 'public/images/products'
            $imgPath = $request->file('img')->store('images/products', 'public');
        }

        try {
            // 3. Simpan Produk Utama
            $product = Product::create([
                'store_id' => $validatedData['store_id'],
                'name' => $validatedData['name'],
                'desc' => $validatedData['desc'],
                'category' => $validatedData['category'] ?? null,
                'type' => $validatedData['type'] ?? null,
                'price' => $validatedData['price'] ?? null,
                'img' => $imgPath,
            ]);

            // 4. Buat Varian Utama jika Tipe produk bukan kosong
            if (in_array($request->type, ['Sepatu', 'Baju', 'None'])) {
                
                $variantData = [
                    'color' => $validatedData['color'],
                    'price' => $validatedData['price'] ?? 0, // Ambil harga default dari produk utama
                    'img' => $imgPath, // Gunakan gambar produk utama sebagai gambar varian default
                ];

                // Proses Ukuran hanya jika ada (Sepatu atau Baju)
                if (in_array($request->type, ['Sepatu', 'Baju']) && isset($validatedData['sizes'])) {
                    // Pecah string koma menjadi array, bersihkan spasi berlebih, dan hapus nilai kosong
                    $sizesArray = array_map('trim', explode(',', $validatedData['sizes']));
                    $variantData['sizes'] = array_filter($sizesArray);
                } else {
                    $variantData['sizes'] = null; // Tidak ada ukuran untuk tipe 'None'
                }
                
                // Simpan varian
                $product->variants()->create($variantData);
            }

            return redirect()->route('admin.produk.index')->with('success', 'Produk baru dan varian utama berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani error dan kembalikan user ke form dengan input lama
            // Hapus gambar yang mungkin sudah terupload jika terjadi error pada saat simpan ke DB
            if ($imgPath) {
                 Storage::disk('public')->delete($imgPath);
            }
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
    // KUSTOM UNTUK PRODUCT VARIANT
    // ===================================

    /**
     * Menyimpan variant baru untuk produk tertentu.
     */
    public function storeVariant(Request $request, Product $product)
    {
        // PERBAIKAN: Memastikan validasi regex untuk sizes juga berlaku di sini
        $request->validate([
            'color' => 'required|string|max:100', 
            'price' => 'nullable|numeric|min:0',
            'sizes' => [
                'nullable', 
                'string',
                // Validasi sizes berdasarkan tipe produk utama yang sudah tersimpan
                Rule::when($product->type === 'Sepatu', ['regex:/^[\d,]+$/', 'max:255']),
                Rule::when($product->type === 'Baju', ['regex:/^[\w\s,]+$/', 'max:255']),
            ],
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. PERSIAPAN DATA
        $data = $request->only(['color', 'price']);

        // A. PEMROSESAN FIELD 'sizes'
        if ($request->filled('sizes')) {
            // Pecah string koma menjadi array, bersihkan spasi berlebih, dan hapus nilai kosong
            $sizesArray = array_map('trim', explode(',', $request->sizes));
            $data['sizes'] = array_filter($sizesArray);
        } else {
            $data['sizes'] = null;
        }

        // B. PENANGANAN GAMBAR
        $data['img'] = null;
        if ($request->hasFile('img')) {
            // Simpan gambar ke storage dan dapatkan path-nya
            $data['img'] = $request->file('img')->store('product_variants', 'public');
        }

        // 3. PROSES SIMPAN
        try {
            // Simpan varian yang terikat pada produk ini menggunakan relasi
            $product->variants()->create($data);

            return redirect()->route('admin.produk.show', $product)->with('success', 'Varian produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani error, tampilkan pesan agar mudah didiagnosis
            return redirect()->back()->with('error', 'Gagal menyimpan varian. Detail: ' . $e->getMessage())->withInput();
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
