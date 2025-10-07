<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductVariant;
use App\Models\ProductSize;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store1 = Store::firstOrCreate(
            ['name' => 'Bogor Square'],
            ['alamat' => 'Jl. Pajajaran No. 10, Bogor', 'telepon' => '6289602397994']
        );

        $store2 = Store::firstOrCreate(
            ['name' => 'Sengked Store'],
            ['alamat' => 'Jl. Suryakencana No. 5, Bogor', 'telepon' => '6285715727324']
        );

        // ============================
        // PRODUK STORE 1
        // ============================
        $batik = Product::create([
            'name'      => 'Batik Khas Bogor',
            'category'  => 'Unggulan',
            'desc'      => 'Batik motif khas Bogor dengan corak tradisional.',
            'store_id'  => $store1->id,
            'price'     => 250000,
            'type'      => 'baju',
            'img'       => '/storage/produk/pk8.jpg'
        ]);

        $variants = [
            [
                'color' => 'Hijau',
                'img'   => '/storage/produk/pk13.jpg',
                'price' => 250000,
                'sizes' => ['S', 'M', 'L', 'XL']
            ],
            [
                'color' => 'Biru',
                'img'   => '/storage/produk/pk5.jpg',
                'price' => 250000,
                'sizes' => ['S', 'M', 'L']
            ]
        ];

        foreach ($variants as $v) {
            $variant = ProductVariant::create([
                'product_id' => $batik->id,
                'color'      => $v['color'],
                'img'        => $v['img'],
                'price'      => $v['price']
            ]);

            foreach ($v['sizes'] as $s) {
                ProductSize::create([
                    'variant_id' => $variant->id,
                    'size'       => $s
                ]);
            }
        }

        // Produk tanpa variants untuk store 1
        $productsStore1 = [
            [
                'name'     => 'Tas Anyaman Bambu',
                'category' => 'Unggulan',
                'img'      => '/storage/produk/pk6.jpg',
                'price'    => 150000,
                'desc'     => 'Tas anyaman bambu buatan pengrajin lokal.',
                'store_id' => $store1->id,
                'type'     => 'none'
            ],
            [
                'name'     => 'Ukiran Kayu Jati',
                'category' => 'Kerajinan Kayu',
                'img'      => '/storage/produk/p1.jpg',
                'price'    => 500000,
                'desc'     => 'Ukiran kayu jati dengan detail halus.',
                'store_id' => $store1->id,
                'type'     => 'none'
            ],
        ];

        foreach ($productsStore1 as $p) {
            Product::create($p);
        }

        // ============================
        // PRODUK STORE 2
        // ============================
        $sepatu = Product::create([
            'name'     => 'Sepatu Kulit Bogor',
            'category' => 'Unggulan',
            'img'      => '/storage/produk/sepatu rajut.jpg',
            'price'    => 300000,
            'desc'     => 'Sepatu kulit elegan dengan kualitas premium.',
            'store_id' => $store2->id,
            'type'     => 'sepatu'
        ]);

        $sepatuVariants = [
            [
                'color' => 'Hitam',
                'img'   => '/storage/produk/s2.jpg',
                'price' => 300000,
                'sizes' => ['40', '41', '42', '43']
            ],
            [
                'color' => 'Coklat',
                'img'   => '/storage/produk/s1.jpg',
                'price' => 300000,
                'sizes' => ['40', '42', '43']
            ]
        ];

        foreach ($sepatuVariants as $v) {
            $variant = ProductVariant::create([
                'product_id' => $sepatu->id,
                'color'      => $v['color'],
                'img'        => $v['img'],
                'price'      => $v['price']
            ]);

            foreach ($v['sizes'] as $s) {
                ProductSize::create([
                    'variant_id' => $variant->id,
                    'size'       => $s
                ]);
            }
        }

        // produk lain store 2
        $productsStore2 = [
            [
                'name'     => 'Keramik Hias',
                'category' => 'Terbaru',
                'img'      => '/storage/produk/pk2.jpg',
                'price'    => 75000,
                'desc'     => 'Keramik hias dekoratif untuk rumah.',
                'store_id' => $store2->id,
                'type'     => 'none'
            ],
            [
                'name'     => 'Elcraft',
                'category' => 'Terbaru',
                'img'      => '/storage/produk/pk6.jpg',
                'price'    => 200000,
                'desc'     => 'Tas rajut dari Elcraft yang unik dan cantik.',
                'store_id' => $store2->id,
                'type'     => 'tas'
            ]
        ];

        foreach ($productsStore2 as $p) {
            Product::create($p);
        }
    }
}
