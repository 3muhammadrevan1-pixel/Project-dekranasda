<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StatisPage;
use App\Models\TbMenuData;
use App\Models\Store;
use App\Models\ProductVariant; // DIUBAH: Menggunakan ProductVariant
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
             'category' => 'Unggulan', // tambahkan ini
            'price' => 100000,
            'desc' => 'Deskripsi produk untuk tes fitur.',
            'img' => 'dummy/product.png', 
            'type'=> 'none'
        ]);

        // 3. Buat Variant (Varian Produk) dummy
        // PERBAIKAN: Menggunakan ProductVariant::create dan menambahkan kolom 'sizes' (JSON)
        ProductVariant::create([ // DIUBAH: Menggunakan ProductVariant
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
TbMenuData::create([
    'menu_id' => 3, // misalnya 3 = untuk menu Berita
    'title' => 'Berita Tes 1',
    'jenis_konten' => 'berita',
    'content' => 'Konten berita dummy.',
    'img' => 'dummy/news.png',
]);

TbMenuData::create([
    'menu_id' => 4, // misalnya 4 = untuk menu Galeri
    'title' => 'Galeri Tes 1',
    'jenis_konten' => 'galeri',
    'content' => 'Konten galeri dummy.',
    'img' => 'dummy/gallery.png',
]);

    }
}
