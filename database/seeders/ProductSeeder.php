<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductVariant;
// use App\Models\ProductSize; // Dihapus karena tabel sudah tidak ada

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PERBAIKAN: Mengambil Store yang sudah dibuat oleh StoreSeeder, BUKAN membuatnya lagi.
        $store1 = Store::where('name', 'Bogor Square')->first();
        $store2 = Store::where('name', 'Sengked Store')->first();

        // Peringatan: Pastikan StoreSeeder dipanggil sebelum ProductSeeder di DatabaseSeeder.php

        // ============================
        // PRODUK STORE 1
        // ============================
        $batik = Product::create([
            'name'      => 'Batik Khas Bogor',
            'category'  => 'Unggulan',
            'desc'      => 'Batik motif khas Bogor dengan corak tradisional.',
            'store_id'  => $store1->id, // Menggunakan ID Toko yang sudah diambil
            'price'     => 250000,
            'type'      => 'baju',
            'img'       => 'produk/pk8.jpg'
        ]);

        // Variants untuk Batik, DENGAN DATA SIZE (Perbaikan: Menambahkan 'sizes')
        $variants = [
            [
                'color' => 'Hijau',
                'img'   => 'produk/pk13.jpg',
                'price' => 250000,
                'sizes' => ['S', 'M', 'L', 'XL'] // DATA SIZE DITAMBAHKAN
            ],
            [
                'color' => 'Biru',
                'img'   => 'produk/pk5.jpg',
                'price' => 250000,
                'sizes' => ['S', 'M', 'L'] // DATA SIZE DITAMBAHKAN
            ]
        ];

        foreach ($variants as $v) {
            ProductVariant::create([
                'product_id' => $batik->id,
                'color'      => $v['color'],
                'img'        => $v['img'],
                'price'      => $v['price'],
                'sizes'      => $v['sizes'] // SIZE DIMASUKKAN
            ]);
        }

        // Produk tanpa variants untuk store 1
        $productsStore1 = [
            [
                'name'      => 'Tas Anyaman Bambu',
                'category'  => 'Terbaru',
                'img'       => 'produk/pk6.jpg',
                'price'     => 150000,
                'desc'      => 'Tas anyaman bambu buatan pengrajin lokal.',
                'store_id'  => $store1->id,
                'type'      => 'none'
            ],
            [
                'name'      => 'Ukiran Kayu Jati',
                'category'  => 'Kerajinan Kayu',
                'img'       => 'produk/p1.jpg',
                'price'     => 500000,
                'desc'      => 'Ukiran kayu jati dengan detail halus.',
                'store_id'  => $store1->id,
                'type'      => 'none'
            ],
        ];

        foreach ($productsStore1 as $p) {
            Product::create($p);
        }

        // ============================
        // PRODUK STORE 2
        // ============================
        $sepatu = Product::create([
            'name'      => 'Sepatu Kulit Bogor',
            'category'  => 'Unggulan',
            'img'       => 'produk/sepatu rajut.jpg',
            'price'     => 300000,
            'desc'      => 'Sepatu kulit elegan dengan kualitas premium.',
            'store_id'  => $store2->id, // Menggunakan ID Toko yang sudah diambil
            'type'      => 'sepatu'
        ]);

        // Variants untuk Sepatu, DENGAN DATA SIZE (Perbaikan: Menambahkan 'sizes')
        $sepatuVariants = [
            [
                'color' => 'Hitam',
                'img'   => 'produk/s2.jpg',
                'price' => 300000,
                'sizes' => ['40', '41', '42', '43'] // DATA SIZE DITAMBAHKAN
            ],
            [
                'color' => 'Coklat',
                'img'   => 'produk/s1.jpg',
                'price' => 300000,
                'sizes' => ['40', '42', '43'] // DATA SIZE DITAMBAHKAN
            ]
        ];

        foreach ($sepatuVariants as $v) {
            ProductVariant::create([
                'product_id' => $sepatu->id,
                'color'      => $v['color'],
                'img'        => $v['img'],
                'price'      => $v['price'],
                'sizes'      => $v['sizes'] // SIZE DIMASUKKAN
            ]);
        }

        // produk lain store 2
        $productsStore2 = [
            [
                'name'      => 'Keramik Hias',
                'category'  => 'Terbaru',
                'img'       => 'produk/pk2.jpg',
                'price'     => 75000,
                'desc'      => 'Keramik hias dekoratif untuk rumah.',
                'store_id'  => $store2->id,
                'type'      => 'none'
            ],
            [
                'name'      => 'Elcraft',
                'category'  => 'Terbaru',
                'img'       => 'produk/pk6.jpg',
                'price'     => 200000,
                'desc'      => 'Tas rajut dari Elcraft yang unik dan cantik.',
                'store_id'  => $store2->id,
                'type'      => 'none'
            ]
        ];

        foreach ($productsStore2 as $p) {
            Product::create($p);
        }
    }
}
