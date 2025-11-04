<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store; 


class StoreController extends Controller 
{
    /**
     * Tampilkan daftar semua Toko (READ - Index).
     * Diurutkan berdasarkan ID secara 'asc' (terlama di atas).
     */
    public function index()
    {
        // PERBAIKAN: Mengubah 'desc' menjadi 'asc' untuk menampilkan ID terlama di atas
        $stores = Store::with('products')->orderBy('id', 'asc')->get(); 
        
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

        return redirect()->route('admin.toko.index')
            ->with('success', 'Toko berhasil ditambahkan! ✅');
    }

    /**
     * Tampilkan formulir untuk mengedit Toko tertentu (UPDATE - Edit Form).
     * Menerima Store $toko (sesuai nama parameter route: {toko}).
     */
    public function edit(Store $toko) // <-- DIKEMBALIKAN: Menggunakan $toko untuk Route Model Binding
    {
        // Mengirim data ke view dengan nama 'store' (agar sesuai dengan edit.blade.php)
        return view('admin.toko.edit', ['store' => $toko]); 
    }

    /**
     * Perbarui data Toko di database (UPDATE - Update).
     */
    public function update(Request $request, Store $toko) // <-- DIKEMBALIKAN: Menggunakan $toko untuk Route Model Binding
    {
        $validatedData = $request->validate([
            'name'      => 'required|string|max:100',
            'alamat'    => 'nullable|string|max:255',
            'telepon'   => 'nullable|string|max:20',
        ]);

        $toko->update($validatedData);

        return redirect()->route('admin.toko.index')
            ->with('success', 'Toko berhasil diperbarui! 💾');
    }

    /**
     * Hapus Toko dari database (DELETE).
     */
    public function destroy(Store $toko)
    {
        $toko->delete();

        return redirect()->route('admin.toko.index')
            ->with('success', 'Toko berhasil dihapus! 🗑️');
    }
}
