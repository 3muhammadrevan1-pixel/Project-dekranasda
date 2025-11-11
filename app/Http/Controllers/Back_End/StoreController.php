<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller 
{
    /**
     * Tampilkan daftar semua Toko (READ - Index).
     * Menggunakan pagination (5 item per halaman) dan eager loading produk.
     */
    public function index()
    {
        // Mengubah ->get() menjadi ->paginate(5) untuk mengaktifkan penomoran halaman
        // Data diurutkan berdasarkan ID secara 'asc' (terlama di atas).
        $stores = Store::with('products')
                      ->orderBy('id', 'asc')
                      ->paginate(5); 

        return view('admin.toko.index', compact('stores')); 
    }

    /**
     * Tampilkan formulir untuk membuat Toko baru (CREATE - Form).
     */
    public function create()
    {
        return view('admin.toko.create');
    }

    /**
     * Simpan Toko baru ke database (CREATE - Store).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'      => 'required|string|max:100',
            'alamat'    => 'nullable|string|max:255',
            'telepon'   => 'nullable|string|max:20',
        ]);

        Store::create($validatedData);

        // Redirect dengan prefix dinamis
        $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
        return redirect()->route($rolePrefix . '.toko.index')
            ->with('success', 'Toko berhasil ditambahkan! ✅');
    }

    /**
     * Tampilkan formulir untuk mengedit Toko tertentu (UPDATE - Edit Form).
     * Menggunakan $store agar sesuai dengan route model binding operator.
     */
    public function edit(Store $store)
    {
        return view('admin.toko.edit', compact('store'));
    }

    /**
     * Perbarui data Toko di database (UPDATE - Update).
     */
    public function update(Request $request, Store $store)
    {
        $validatedData = $request->validate([
            'name'      => 'required|string|max:100',
            'alamat'    => 'nullable|string|max:255',
            'telepon'   => 'nullable|string|max:20',
        ]);

        $store->update($validatedData);

        $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
        return redirect()->route($rolePrefix . '.toko.index')
            ->with('success', 'Toko berhasil diperbarui! 💾');
    }

    /**
     * Hapus Toko dari database (DELETE).
     */
    public function destroy(Store $store)
    {
        $store->delete();

        $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
        return redirect()->route($rolePrefix . '.toko.index')
            ->with('success', 'Toko berhasil dihapus! 🗑️');
    }
}