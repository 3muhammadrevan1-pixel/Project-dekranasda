<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TbMenuData;
use App\Models\StatisPage;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        // Muat semua produk termasuk store dan variants.
        $allProducts = Product::with(['store', 'variants'])->get();

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
                        // Asumsi sizes sudah tidak ada di model variant, hanya untuk jaga-jaga
                       'sizes' => $variant->sizes ?? [],
                    ];
                })
            ];
        });

        $galeri = TbMenuData::ofJenis('galeri')->take(6)->get();


        $news = TbMenuData::ofJenis('berita')->latest()->take(6)->get();
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
            'galeri',
            'allProducts',
            'allProductsJs',
            'visi',
            'misi',
            'fokus',
            'programKerja'
        ))->with('title', 'Beranda - Dekranasda Kota Bogor');
    }
}
