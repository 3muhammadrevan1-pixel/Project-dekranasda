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
     * Data di sini berfungsi sebagai data dummy minimal
     * agar HomeController@index dapat mengambil data tanpa error.
     */
    public function run()
    {
        // Pastikan model yang dibutuhkan oleh Product::with(['store', 'variants']) ada
        
        // 1. Buat Store (Toko) dummy
        $store = Store::create([
            'name' => 'Toko Dummy Dekranasda',
            'alamat' => 'Alamat Tes',
            'telepon' => '12345',
            // 'deskripsi' => 'Deskripsi Toko Tes', // BARIS INI DIHAPUS KARENA TIDAK DITEMUKAN DI MIGRATION
        ]);

        // 2. Buat Product (Produk) dummy
        $product = Product::create([
            'store_id' => $store->id,
            'name' => 'Produk Tes Utama',
            'price' => 100000,
            'desc' => 'Deskripsi produk untuk tes fitur.',
            'img' => 'dummy/product.png', // Tambahkan placeholder image path
        ]);

        // 3. Buat Variant (Varian Produk) dummy
        // PERBAIKAN: Menggunakan ProductVariant::create dan menambahkan kolom 'sizes' (JSON)
        ProductVariant::create([
            'product_id' => $product->id,
            'color' => 'Merah',
            'price' => 105000,
            'img' => 'dummy/variant.png',
            'sizes' => json_encode(['S', 'M', 'L', 'XL']), // Tambahkan kolom sizes
        ]);
        
        // 4. Buat StatisPage (untuk Visi Misi dan Program Kerja)
        // PERBAIKAN: Menghapus kolom 'jenis'
        // HomeController@index memanggil StatisPage::where('slug', 'visi-misi')->first()
        StatisPage::create([
            'judul' => 'Visi Misi Tes',
            'slug' => 'visi-misi',
            // Konten harus berupa JSON valid agar json_decode tidak error
            'konten' => json_encode([
                ['title' => 'Visi', 'text' => 'Visi Tes'], 
                ['title' => 'Misi', 'text' => 'Misi Tes']
            ]),
            // 'jenis' => 'halaman' // BARIS INI DIHAPUS SESUAI PERMINTAAN
        ]);

        // HomeController@index memanggil StatisPage::where('slug', 'program-kerja')->first()
        StatisPage::create([
            'judul' => 'Program Kerja Tes',
            'slug' => 'program-kerja',
            'konten' => '[]',
            // 'jenis' => 'halaman' // BARIS INI DIHAPUS SESUAI PERMINTAAN
        ]);

        // 5. Buat TbMenuData (untuk galeri dan berita)
        // PERBAIKAN: Mengganti 'judul' -> 'title', 'jenis' -> 'jenis_konten', 'konten' -> 'content'
        
        // Tambahkan satu Berita
        TbMenuData::create([
            'title' => 'Berita Tes 1',
            'jenis_konten' => 'berita',
            'slug' => Str::slug('Berita Tes 1'),
            'content' => 'Konten berita dummy.',
            'img' => 'dummy/news.png',
        ]);

        // Tambahkan satu Galeri
        TbMenuData::create([
            'title' => 'Galeri Tes 1',
            'jenis_konten' => 'galeri',
            'slug' => Str::slug('Galeri Tes 1'),
            'content' => 'Konten galeri dummy.',
            'img' => 'dummy/gallery.png',
        ]);
    }
}
