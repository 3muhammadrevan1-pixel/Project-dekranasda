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
    
    private function rolePrefix()
    {
        return auth()->user()->role === 'operator' ? 'operator' : 'admin';
    }

    /**
     * Tampilkan daftar produk aktif (default Laravel Soft Deletes)
     * Menggunakan pagination dan eager loading untuk performa.
     */
    public function index()
    {
        // Secara default, Product::get() atau Product::paginate() hanya mengambil data yang belum di-soft delete
        $products = Product::with(['store', 'variants'])
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.produk.index', compact('products'));
    }

    /**
     * BARU: Tampilkan daftar produk yang di-Soft Delete (Sampah/Trash)
     * Menggunakan scope onlyTrashed().
     */
    public function trash()
    {
        $products = Product::onlyTrashed() // Hanya ambil produk yang sudah dihapus (deleted_at IS NOT NULL)
            ->with(['store', 'variants'])
            ->orderBy('deleted_at', 'desc') // Diurutkan berdasarkan waktu dihapus terbaru
            ->paginate(10);

        return view('admin.produk.trash', compact('products'));
    }

    public function create()
    {
        $stores = Store::all(['id', 'name']);
        return view('admin.produk.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $rolePrefix = $this->rolePrefix();

        $rules = [
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:150',
            'desc' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'type' => 'required|string|max:100|in:warna_angka,warna_huruf,warna,tunggal',
            'price' => 'required|numeric|min:0',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        switch ($request->type) {
            case 'warna_angka':
                $rules['color'] = 'required|string|max:100';
                $rules['sizes'] = ['required', 'string', 'regex:/^\s*[0-9]+(\s*,\s*[0-9]+)*\s*$/'];
                break;
            case 'warna_huruf':
                $rules['color'] = 'required|string|max:100';
                $rules['sizes'] = ['required', 'string', 'regex:/^\s*[a-zA-Z]+(\s*,\s*[a-zA-Z]+)*\s*$/'];
                break;
            case 'warna':
                $rules['color'] = 'required|string|max:100';
                break;
        }

        $validated = $request->validate($rules, [
            'sizes.required' => 'Ukuran wajib diisi!',
            'sizes.regex' => 'Ukuran tidak sesuai tipe produk!',
            'price.required' => 'Harga wajib diisi!',
            'price.min' => 'Harga tidak boleh negatif!',
            'color.required' => 'Warna/Nama varian wajib diisi!',
            'img.required' => 'Gambar produk wajib diisi!',
        ]);

        try {
            $imgPath = $request->file('img')->store('images/products', 'public');

            $product = Product::create([
                'store_id' => $validated['store_id'],
                'name' => $validated['name'],
                'desc' => $validated['desc'] ?? null,
                'category' => $validated['category'] ?? null,
                'type' => $validated['type'],
                'price' => $validated['price'],
                'img' => $imgPath,
            ]);

            if (in_array($validated['type'], ['warna_angka', 'warna_huruf', 'warna'])) {
                $product->variants()->create([
                    'color' => $validated['color'],
                    'price' => $validated['price'],
                    'img' => $imgPath,
                    'sizes' => isset($validated['sizes'])
                        ? array_values(array_filter(array_map('trim', explode(',', $validated['sizes']))))
                        : [],
                ]);
            }

            return redirect()->route($rolePrefix . '.produk.index')
                ->with('success', 'Produk baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            if (!empty($imgPath)) Storage::disk('public')->delete($imgPath);
            return back()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Product $product)
    {
        $product->load(['variants', 'store']);
        return view('admin.produk.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $stores = Store::all(['id', 'name']);
        return view('admin.produk.edit', compact('product', 'stores'));
    }

    public function update(Request $request, Product $product)
    {
        $rolePrefix = $this->rolePrefix();

        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:150',
            'desc' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['type'] = $product->type;

        try {
            if ($request->hasFile('img')) {
                // Jika gambar baru diunggah, hapus gambar lama
                if ($product->img) Storage::disk('public')->delete($product->img);
                $validated['img'] = $request->file('img')->store('images/products', 'public');
            } else {
                $validated['img'] = $product->img;
            }

            $product->update($validated);

            if ($product->type !== 'tunggal') {
                $firstVariant = $product->variants()->first();
                if ($firstVariant) {
                    // Jika varian ada, update harga dan gambar varian pertama
                    $firstVariant->update([
                        'price' => $validated['price'],
                        'img' => $validated['img'],
                    ]);
                }
            }

            return redirect()->route($rolePrefix . '.produk.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            if ($request->hasFile('img')) Storage::disk('public')->delete($validated['img']);
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mengubah menjadi Soft Delete (pindah ke Sampah)
     * Hanya set deleted_at. Gambar dan varian tetap di database.
     */
    public function destroy(Product $product)
    {
        $rolePrefix = $this->rolePrefix();

        try {
            // Memanggil Soft Delete (mengisi kolom deleted_at)
            // Relasi ProductVariant TIDAK menggunakan SoftDeletes, jadi varian tetap ada
            $product->delete(); 
            return redirect()->route($rolePrefix . '.produk.index')->with('success', 'Produk berhasil dipindahkan ke Sampah!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memindahkan produk ke Sampah: ' . $e->getMessage());
        }
    }

    /**
     * BARU: Memulihkan produk dari Sampah (Restore)
     */
    public function restore($id)
    {
        $rolePrefix = $this->rolePrefix();
        // Cari produk HANYA di sampah (onlyTrashed)
        $product = Product::onlyTrashed()->findOrFail($id);

        try {
            $product->restore(); // Mengubah deleted_at menjadi NULL
            return redirect()->route($rolePrefix . '.produk.trash')->with('success', 'Produk berhasil dipulihkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memulihkan produk: ' . $e->getMessage());
        }
    }

    /**
     * BARU: Menghapus produk secara permanen dari database (Force Delete)
     * Termasuk menghapus aset (gambar) dan relasi (varian).
     */
    public function forceDelete($id)
    {
        $rolePrefix = $this->rolePrefix();
        // Cari produk HANYA di sampah (onlyTrashed)
        $product = Product::onlyTrashed()->findOrFail($id);

        try {
            // 1. Hapus gambar terkait sebelum menghapus permanen
            if ($product->img) Storage::disk('public')->delete($product->img);
            
            // 2. Hapus permanen semua varian yang terkait (ProductVariant tidak menggunakan SoftDeletes)
            // Ini adalah langkah penting untuk menjaga integritas data.
            $product->variants()->delete(); 

            // 3. Hapus produk secara permanen dari database
            $product->forceDelete();

            return redirect()->route($rolePrefix . '.produk.trash')->with('success', 'Produk berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus produk permanen: ' . $e->getMessage());
        }
    }


    // =====================================================
    //              MANAJEMEN VARIAN PRODUK
    // =====================================================

    public function createVariant(Product $product)
    {
        return view('admin.produk.create-variant', compact('product'));
    }

    public function storeVariant(Request $request, Product $product)
    {
        $rolePrefix = $this->rolePrefix();

        $rules = [
            'color' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        if (in_array($product->type, ['warna_angka', 'warna_huruf'])) {
            $rules['sizes'] = [
                'required',
                'string',
                Rule::when($product->type === 'warna_angka', ['regex:/^\s*[0-9]+(\s*,\s*[0-9]+)*\s*$/']),
                Rule::when($product->type === 'warna_huruf', ['regex:/^\s*[a-zA-Z]+(\s*,\s*[a-zA-Z]+)*\s*$/']),
            ];
        }

        $request->validate($rules, [
            'sizes.required' => 'Ukuran wajib diisi!',
            'sizes.regex' => 'Ukuran tidak sesuai tipe produk!',
            'color.required' => 'Warna wajib diisi!',
            'price.required' => 'Harga wajib diisi!',
            'img.required' => 'Gambar varian wajib diisi!',
        ]);

        $data = $request->only(['color', 'price']);
        $data['sizes'] = isset($request->sizes)
            ? array_values(array_filter(array_map('trim', explode(',', $request->sizes))))
            : [];
        $data['img'] = $request->file('img')->store('product_variants', 'public');

        try {
            $variant = $product->variants()->create($data);

            if ($product->variants()->count() === 1) {
                $product->update([
                    'price' => $variant->price,
                    'img' => $variant->img,
                ]);
            }

            return redirect()->route($rolePrefix . '.produk.show', $product)
                ->with('success', 'Varian berhasil ditambahkan!');
        } catch (\Exception $e) {
            if (!empty($data['img'])) Storage::disk('public')->delete($data['img']);
            return back()->with('error', 'Gagal menyimpan varian: ' . $e->getMessage())->withInput();
        }
    }

    public function editVariant(ProductVariant $variant)
    {
        $variant->load('product');
        return view('admin.produk.edit-variant', compact('variant'));
    }

    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $rolePrefix = $this->rolePrefix();
        $product = $variant->product;

        $rules = [
            'color' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'img' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        if (in_array($product->type, ['warna_angka', 'warna_huruf'])) {
            $rules['sizes'] = [
                'required',
                'string',
                Rule::when($product->type === 'warna_angka', ['regex:/^\s*[0-9]+(\s*,\s*[0-9]+)*\s*$/']),
                Rule::when($product->type === 'warna_huruf', ['regex:/^\s*[a-zA-Z]+(\s*,\s*[a-zA-Z]+)*\s*$/']),
            ];
        }

        $request->validate($rules);

        $data = $request->only(['color', 'price']);
        $data['sizes'] = isset($request->sizes)
            ? array_values(array_filter(array_map('trim', explode(',', $request->sizes))))
            : [];

        $oldImg = $variant->img;
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('product_variants', 'public');
            if ($oldImg) Storage::disk('public')->delete($oldImg);
        } else {
            $data['img'] = $oldImg;
        }

        try {
            $variant->update($data);

            $firstVariant = $product->variants()->first();
            if ($variant->id === $firstVariant->id) {
                $product->update([
                    'price' => $variant->price,
                    'img' => $variant->img,
                ]);
            }

            return redirect()->route($rolePrefix . '.produk.show', $product)
                ->with('success', 'Varian berhasil diperbarui!');
        } catch (\Exception $e) {
            if ($request->hasFile('img')) Storage::disk('public')->delete($data['img']);
            return back()->with('error', 'Gagal memperbarui varian: ' . $e->getMessage())->withInput();
        }
    }

    public function destroyVariant(ProductVariant $variant)
    {
        $rolePrefix = $this->rolePrefix();
        $product = $variant->product;

        try {
            if ($variant->img) Storage::disk('public')->delete($variant->img);
            $variant->delete();

            $firstVariant = $product->variants()->first();
            if ($firstVariant) {
                $product->update([
                    'price' => $firstVariant->price,
                    'img' => $firstVariant->img,
                ]);
            }

            return redirect()->route($rolePrefix . '.produk.show', $product)
                ->with('success', 'Varian berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus varian: ' . $e->getMessage());
        }
    }
}