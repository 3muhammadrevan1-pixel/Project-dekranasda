<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller; 
use App\Models\TbMenu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Tampilkan daftar menu.
     */
    public function index()
    {
        // Tampilkan menu beserta parent-nya, urut berdasarkan ID terlama (ASC).
        // Ini memastikan data yang paling lama dibuat muncul di atas.
        $menus = TbMenu::with('parent')
            ->orderBy('id', 'asc') // DISESUAIKAN: Mengurutkan berdasarkan ID terlama
            ->paginate(5); 

        return view('admin.menu.index', compact('menus'));
    }
    /**
     * Form tambah menu.
     */
    public function create()
    {
        // Mengambil SEMUA menu top-level (parent_id = 0) untuk dijadikan opsi menu induk.
        $parentMenus = TbMenu::where('parent_id', 0)
            ->orderBy('urutan')
            ->get();

        return view('admin.menu.create', compact('parentMenus'));
    }

    /**
     * Simpan menu baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'parent_id' => 'required|integer|min:0',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                // Validasi urutan unik per parent
                Rule::unique('tb_menu')->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request->parent_id);
                }),
            ],
            'tipe' => 'required|in:statis,dinamis',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'urutan.unique' => 'Nomor urutan sudah digunakan dalam menu induk yang sama.',
            'urutan.required' => 'Kolom urutan wajib diisi.',
        ]);

        TbMenu::create($request->all());

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail menu.
     */
    public function show(TbMenu $menu)
    {
        $contents = $menu->contents()->orderByDesc('created_at')->get();
        return view('admin.menu.show', compact('menu', 'contents'));
    }

    /**
     * Form edit menu.
     */
    public function edit(TbMenu $menu)
    {
        $parentMenus = TbMenu::where('parent_id', 0)
            ->where('id', '!=', $menu->id)
            ->orderBy('urutan')
            ->get();

        return view('admin.menu.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update data menu.
     */
    public function update(Request $request, TbMenu $menu)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'parent_id' => 'required|integer|min:0',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                // Validasi unik tapi abaikan id dirinya sendiri
                Rule::unique('tb_menu')->where(function ($query) use ($request, $menu) {
                    return $query->where('parent_id', $request->parent_id)
                                 ->where('id', '!=', $menu->id);
                }),
            ],
            'tipe' => 'required|in:statis,dinamis',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'urutan.unique' => 'Nomor urutan sudah digunakan dalam menu induk yang sama.',
            'urutan.required' => 'Kolom urutan wajib diisi.',
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Hapus menu.
     */
    public function destroy(TbMenu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
