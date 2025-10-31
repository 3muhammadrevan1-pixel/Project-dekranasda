<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TbMenuData; // WAJIB: Menggunakan Model konten baru

class BeritaController extends Controller
{
    /**
     * Menampilkan detail berita ketika 'Baca Selengkapnya' diklik.
     * Menerima ID dari baris TbMenuData.
     * Route: /berita/{id}
     * View: news.show
     */
    public function show(string $id)
    {
        // 1. Cari konten di tabel tb_menu_data
        // 2. Pastikan jenisnya 'berita' (menggunakan Scope ofJenis dari Model)
        // 3. Jika tidak ditemukan (ID salah atau bukan jenis berita), lempar 404
        $berita = TbMenuData::ofJenis('berita')->findOrFail($id);

        // Mengirim objek detail dengan nama 'berita' ke view 'news.show'
        return view('news.show', compact('berita'));
    }
    
    // Semua metode CRUD (create, store, edit, update, destroy) dihilangkan
    // karena tugas manajemen data (Admin) sudah dipindahkan ke AdminMenuDataController.
}
