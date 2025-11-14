<?php

namespace App\Http\Controllers\Front_End;

use App\Http\Controllers\Controller;
use App\Models\TbMenu;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MenuContentController extends Controller
{
    /**
     * Menampilkan daftar konten untuk suatu Menu (Halaman Dinamis Utama).
     * URL: /menu/{slug}
     *
     * @param string $slug Slug dari menu yang dicari (misal: "berita" atau "tentang-kami")
     * @return \Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        try {
            // 1. Ambil data Menu Induk (TbMenu) berdasarkan slug
            // Mencari menu yang statusnya 'aktif' dan memiliki slug yang cocok.
            $menu = TbMenu::where('slug', $slug)
                          ->where('status', 'aktif')
                          // Eager load data konten (menuData) yang terkait dengan menu ini.
                          ->with(['menuData' => function($query) {
                              // Urutkan konten berdasarkan created_at terbaru agar item terbaru muncul di atas
                              $query->orderByDesc('created_at');
                          }])
                          ->firstOrFail(); // Jika tidak ditemukan, akan melempar ModelNotFoundException

            // 2. Data konten yang akan di-loop di view
            $menu_data = $menu->menuData;

            // 3. Panggil VIEW UTAMA (frontend.dynamic_page)
            return view('frontend.dynamic_page', [
                'menu' => $menu,
                'menu_data' => $menu_data,
            ]);
            
        } catch (ModelNotFoundException $e) {
            // Jika menu tidak ditemukan (slug salah) atau tidak aktif
            abort(404, 'Halaman yang Anda cari tidak ditemukan.');
        }
    }
}