<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatisPage;
use App\Models\TbMenu;      // Diperlukan untuk mencari ID menu
use App\Models\TbMenuData;  // Diperlukan untuk mengambil konten menu

class StatisPageController extends Controller
{
    /**
     * Menampilkan halaman Sejarah (rute statis yang sudah ada).
     */
    public function sejarah()
    {
        $page = StatisPage::where('slug', 'sejarah')->first();

        if (!$page) {
            abort(404, 'Halaman tidak ditemukan');
        }

        return view('about.sejarah', compact('page'));
    }
    
    /**
     * Menampilkan halaman konten dinamis berdasarkan slug dari URL (/halaman/{slug}).
     * Fungsi ini menangani semua menu baru yang dibuat di admin.
     */
    public function dynamicPage($slug)
    {
        // 1. Konversi slug menjadi Nama Menu yang ada di database.
        // Contoh: 'kontak-kami' menjadi 'Kontak Kami'
        $menuName = ucwords(str_replace('-', ' ', $slug));

        // 2. Cari Menu ID di tabel tb_menu.
        $menu = TbMenu::where('nama', $menuName)->first();

        if (!$menu) {
            // Jika menu tidak ditemukan, tampilkan 404.  0
            abort(404, 'Menu atau Halaman statis tidak ditemukan.');
        }

        // 3. Ambil semua data/konten yang terkait dengan menu ID tersebut dari TbMenuData.
        $menu_data = TbMenuData::where('menu_id', $menu->id)
                               ->orderBy('id', 'asc')
                               ->get();

        // 4. Tampilkan view dinamis (dynamic_page.blade.php).
        return view('front_end.dynamic_page', compact('menu', 'menu_data'));
    }
}