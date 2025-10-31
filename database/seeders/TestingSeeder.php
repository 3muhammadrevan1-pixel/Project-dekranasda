<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StatisPage;
use App\Models\TbMenuData;
use App\Models\Store;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class TestingSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Nonaktifkan foreign key check sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2️⃣ Buat Store dummy kalau belum ada
        $store = \App\Models\Store::firstOrCreate(
            ['name' => 'Toko Dummy Dekranasda'],
            ['alamat' => 'Alamat Tes', 'telepon' => '12345']
        );

        // 3️⃣ Buat Product dummy kalau belum ada
        $product = \App\Models\Product::firstOrCreate(
            ['name' => 'Produk Tes Utama'],
            [
                'store_id' => $store->id,
                'category' => 'Unggulan',
                'price' => 100000,
                'desc' => 'Deskripsi produk untuk tes fitur.',
                'img' => 'dummy/product.png',
                'type' => 'none',
            ]
        );

        // 4️⃣ Buat Variant dummy
        \App\Models\ProductVariant::firstOrCreate(
            ['product_id' => $product->id, 'color' => 'Merah'],
            [
                'price' => 105000,
                'img' => 'dummy/variant.png',
                'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            ]
        );

        // 5️⃣ StatisPage dummy
        \App\Models\StatisPage::firstOrCreate(
            ['slug' => 'visi-misi'],
            ['judul' => 'Visi Misi Tes', 'konten' => json_encode([
                ['title' => 'Visi', 'text' => 'Visi Tes'],
                ['title' => 'Misi', 'text' => 'Misi Tes'],
            ])]
        );

        \App\Models\StatisPage::firstOrCreate(
            ['slug' => 'program-kerja'],
            ['judul' => 'Program Kerja Tes', 'konten' => '[]']
        );

        // 6️⃣ Tambahkan dummy menu (kalau belum ada)
        $menuBerita = DB::table('tb_menu')->where('nama', 'Berita')->first();
        if (!$menuBerita) {
            DB::table('tb_menu')->insert([
                'nama' => 'Berita',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $menuBerita = DB::table('tb_menu')->where('nama', 'Berita')->first();
        }

        $menuGaleri = DB::table('tb_menu')->where('nama', 'Galeri')->first();
        if (!$menuGaleri) {
            DB::table('tb_menu')->insert([
                'nama' => 'Galeri',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $menuGaleri = DB::table('tb_menu')->where('nama', 'Galeri')->first();
        }

        // 7️⃣ Buat TbMenuData dummy (Berita)
        \App\Models\TbMenuData::firstOrCreate(
            ['menu_id' => $menuBerita->id, 'jenis_konten' => 'berita'],
            [
                'title' => 'Berita Dummy',
                'content' => 'Konten berita dummy.',
                'img' => 'dummy/news.png',
            ]
        );

        // 8️⃣ Buat TbMenuData dummy (Galeri)
        \App\Models\TbMenuData::firstOrCreate(
            ['menu_id' => $menuGaleri->id, 'jenis_konten' => 'galeri'],
            [
                'title' => 'Galeri Dummy',
                'content' => 'Konten galeri dummy.',
                'img' => 'dummy/gallery.png',
            ]
        );

        // 9️⃣ Aktifkan lagi foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
