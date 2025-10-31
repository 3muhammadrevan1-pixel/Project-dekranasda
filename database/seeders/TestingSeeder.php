<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StatisPage;
use App\Models\TbMenuData;
use App\Models\Store;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class TestingSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     * Data ini sebagai data dummy minimal agar HomeController@index tidak error.
     */
    public function run()
    {
        // 1. Buat Store dummy
        $store = Store::create([
            'name' => 'Toko Dummy Dekranasda',
            'alamat' => 'Alamat Tes',
            'telepon' => '12345',
        ]);

        // 2. Buat Product dummy
        $product = Product::create([
            'store_id' => $store->id,
            'name' => 'Produk Tes Utama',
            'category' => 'Unggulan',
            'price' => 100000,
            'desc' => 'Deskripsi produk untuk tes fitur.',
            'img' => 'dummy/product.png',
            'type' => 'none',
        ]);

        // 3. Buat Variant dummy
        ProductVariant::create([
            'product_id' => $product->id,
            'color' => 'Merah',
            'price' => 105000,
            'img' => 'dummy/variant.png',
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
        ]);

        // 4. Buat StatisPage dummy (Visi Misi)
        StatisPage::create([
            'judul' => 'Visi Misi Tes',
            'slug' => 'visi-misi',
            'konten' => json_encode([
                ['title' => 'Visi', 'text' => 'Visi Tes'],
                ['title' => 'Misi', 'text' => 'Misi Tes'],
            ]),
        ]);

        // 5. Buat StatisPage dummy (Program Kerja)
        StatisPage::create([
            'judul' => 'Program Kerja Tes',
            'slug' => 'program-kerja',
            'konten' => '[]',
        ]);

        // 6. Buat TbMenuData dummy (Berita)
        TbMenuData::create([
            'menu_id' => 3, // misalnya 3 = menu Berita
            'jenis_konten' => 'berita',
            'title' => 'beritaa tai',
            'content' => 'Konten berita dummy.',
            'img' => 'dummy/news.png',
        ]);

        // 7. Buat TbMenuData dummy (Galeri)
        TbMenuData::create([
            'menu_id' => 4, // misalnya 4 = menu Galeri
            'jenis_konten' => 'galeri',
            'content' => 'Konten galeri dummy.',
            'img' => 'dummy/gallery.png',
        ]);
    }
}
