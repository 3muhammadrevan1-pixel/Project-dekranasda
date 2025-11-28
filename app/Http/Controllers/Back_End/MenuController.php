<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller; 
use App\Models\TbMenu;
use App\Models\TbMenuData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Tampilkan daftar menu.
     */
    public function index()
    {
        $menus = TbMenu::with('parent')
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Form tambah menu.
     */
    public function create()
    {
        $parentMenus = TbMenu::where('parent_id', 0)
            ->orderBy('urutan')
            ->get();

        $jenisKontenOptions = TbMenuData::JENIS_KONTEN;

        return view('admin.menu.create', compact('parentMenus', 'jenisKontenOptions'));
    }

    /**
     * Simpan menu baru.
     */
    public function store(Request $request)
    {
        $validJenisKonten = array_keys(TbMenuData::JENIS_KONTEN);

        $request->validate([
            'nama' => 'required|string|max:100',
            'parent_id' => 'required|integer|min:0',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tb_menu')->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request->parent_id);
                }),
            ],
            'jenis_konten' => [
                'required',
                'string',
                Rule::in($validJenisKonten)
            ],
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'urutan.unique' => 'Nomor urutan sudah digunakan dalam menu induk yang sama.',
            'urutan.required' => 'Kolom urutan wajib diisi.',
            'jenis_konten.required' => 'Kolom Jenis Konten wajib diisi.',
            'jenis_konten.in' => 'Jenis konten yang dipilih tidak valid.',
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
                Rule::unique('tb_menu')->where(function ($query) use ($request, $menu) {
                    return $query->where('parent_id', $request->parent_id)
                                 ->where('id', '!=', $menu->id);
                }),
            ],
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'urutan.unique' => 'Nomor urutan sudah digunakan dalam menu induk yang sama.',
            'urutan.required' => 'Kolom urutan wajib diisi.',
         ]);

        // Hanya update field yang boleh diubah
        $menu->update([
            'nama'      => $request->nama,
            'parent_id' => $request->parent_id,
            'urutan'    => $request->urutan,
            'status'    => $request->status,
        ]);

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
