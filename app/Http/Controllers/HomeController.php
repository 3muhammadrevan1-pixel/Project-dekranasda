<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TbMenuData;
use App\Models\StatisPage;
use App\Models\TbMenu; // <-- WAJIB: Tambahkan ini untuk mengakses model menu

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Muat semua produk termasuk store dan variants.
        $allProducts = Product::with(['store', 'variants'])->get();

        // Produk unggulan = 10 produk dengan click_count tertinggi
        $topProducts = Product::with(['store', 'variants'])
            ->orderByDesc('click_count')
            ->take(10)
            ->get();

        // Siapkan data untuk JavaScript (JSON)
        $allProductsJs = $allProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'img' => $product->img ? asset('storage/' . $product->img) : null,
                'price' => $product->price,
                'desc' => $product->desc,
                'store' => $product->store ? [
                    'name' => $product->store->name,
                    'alamat' => $product->store->alamat,
                    'telepon' => $product->store->telepon ?? '-',
                ] : null,
                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'color' => $variant->color,
                        'img' => $variant->img ? asset('storage/' . $variant->img) : null,
                        'price' => $variant->price,
                        'sizes' => $variant->sizes ?? [],
                    ];
                })
            ];
        });
        // 🔸 Galeri (Media)
        // 1. Cari objek menu 'Galeri'
        $menuGaleri = TbMenu::where('nama', 'Galeri')->first();
        $galeriSlug = $menuGaleri->slug ?? 'galeri'; // Tetap gunakan slug untuk link 'Lihat Semua'

        $galeriTerbaru = collect(); // Default koleksi kosong
        $menuGaleriId = $menuGaleri->id ?? null;

        if ($menuGaleriId) {
            // 2. Ambil TbMenuData yang terasosiasi HANYA dengan ID menu 'Galeri'
            $galeriTerbaru = TbMenuData::where('menu_id', $menuGaleriId)
                // Filter jenis dinamis atau media dipertahankan jika relevan, tapi menu_id adalah filter utama
                ->ofJenis('media') 
                ->latest()
                ->take(8)
                ->get();
        }

       // 🔸 Berita (Dinamis - HANYA DARI MENU BERITA)
        // PERBAIKAN: Mengganti 'slug' menjadi 'nama' karena kolom 'slug' tidak ditemukan.
        // Pastikan nama menu di database persis 'Berita'.
        $menuBerita = TbMenu::where('nama', 'Berita')->first();
        $menuBeritaId = $menuBerita->id ?? null;

        if ($menuBeritaId) {
            // 2. Ambil TbMenuData yang terasosiasi dengan menu ID tersebut
            $news = TbMenuData::where('menu_id', $menuBeritaId)
                // Filter jenis dinamis dipertahankan untuk memastikan konsistensi
                ->ofJenis('dinamis')
                ->latest()
                ->take(6)
                ->get();
        } else {
            // Fallback jika menu 'berita' tidak ditemukan di database
            $news = collect();
        }

        // 🔸 Ambil Visi Misi Fokus
        $visiMisiPage = StatisPage::where('slug', 'visi-misi')->first();
        $visiMisi = $visiMisiPage ? json_decode($visiMisiPage->konten, true) : [];

        $visi = $visiMisi[0] ?? ['title' => '', 'text' => ''];
        $misi = $visiMisi[1] ?? ['title' => '', 'text' => ''];
        $fokus = $visiMisi[2] ?? ['title' => '', 'text' => ''];

        // 🔸 Ambil Program Kerja
        $programKerjaPage = StatisPage::where('slug', 'program-kerja')->first();
        $programKerja = $programKerjaPage ? json_decode($programKerjaPage->konten, true) : [];

        return view('home', compact(
            'news',
            'galeriTerbaru',
            'allProducts',
            'allProductsJs',
            'topProducts',
            'visi',
            'misi',
            'fokus',
            'programKerja',
            'galeriSlug'
        ))->with('title', 'Beranda - Dekranasda Kota Bogor');
    }
}