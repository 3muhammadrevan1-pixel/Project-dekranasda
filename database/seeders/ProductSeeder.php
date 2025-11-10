<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel agar tidak duplikat
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        ProductVariant::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data produk lengkap
        $products = [
            [
                'id' => 1,
                'store_id' => 1,
                'name' => 'Loji Craft',
                'desc' => 'Kemeja etnik Loji Craft, gaya lokal rasa global',
                'img' => 'images/products/vGV1ung5DJ5iD61q3N2PkW74HF2iVB5v6jynM6B7.jpg',
                'category' => 'Fashion',
                'type' => 'warna_huruf',
                'price' => 70000,
                'click_count' => 1,
                'variants' => [
                    ['color' => 'Putih', 'img' => 'images/products/vGV1ung5DJ5iD61q3N2PkW74HF2iVB5v6jynM6B7.jpg', 'price' => 70000, 'sizes' => ['S','M','L','XL','XXL']],
                    ['color' => 'Biru', 'img' => 'product_variants/5UXr430NN37DU0kg77vWgc7FkO2pp28MA3iT5Qdx.jpg', 'price' => 70000, 'sizes' => ['S','M','L','XL']],
                ],
            ],
            [
                'id' => 2,
                'store_id' => 2,
                'name' => 'Jaket Tracktop Parasut',
                'desc' => 'Jual Jaket Tracktop Parasut Pria Wanita',
                'img' => 'product_variants/QyBtrtI6qI0hUvu4SYoYFU1A2Qf3IeRAPu8yHgLN.jpg',
                'category' => 'Fashion',
                'type' => 'warna_huruf',
                'price' => 300000,
                'click_count' => 4,
                'variants' => [
                    ['color' => 'Hitam', 'img' => 'product_variants/QyBtrtI6qI0hUvu4SYoYFU1A2Qf3IeRAPu8yHgLN.jpg', 'price' => 300000, 'sizes' => ['S','M','L','XL','XXL']],
                    ['color' => 'Coklat', 'img' => 'product_variants/qTqZnRnv9UkWlCKrb17fKSr3S3X0U9Q1ee50R6VH.jpg', 'price' => 300000, 'sizes' => ['S','M','L','XL']],
                    ['color' => 'Biru', 'img' => 'product_variants/0jTSiGY1IvwRUmvmm3no8pBdoSQn9d0zPfLAG4QJ.jpg', 'price' => 300000, 'sizes' => ['S','M','L','XL']],
                ],
            ],
            [
                'id' => 3,
                'store_id' => 2,
                'name' => 'Kemeja Wanita',
                'desc' => 'Kemeja Wanita Dengan Desain Simpel Dan Elegan',
                'img' => 'images/products/8EXyQsfHSiwBV8Zj8s2mAQShQGYaYiVt7x3lY3uF.jpg',
                'category' => 'Fashion',
                'type' => 'warna_huruf',
                'price' => 200000,
                'click_count' => 1,
                'variants' => [
                    ['color' => 'Pink', 'img' => 'images/products/8EXyQsfHSiwBV8Zj8s2mAQShQGYaYiVt7x3lY3uF.jpg', 'price' => 200000, 'sizes' => ['S','M','L','XL']],
                    ['color' => 'Putih', 'img' => 'product_variants/EkxA5YtSgDUtSymJfZokQRh3KpNjLKYrMw5Ayuua.jpg', 'price' => 200000, 'sizes' => ['S','M','L','XL']],
                ],
            ],
            [
                'id' => 4,
                'store_id' => 2,
                'name' => 'Sepatu Ortuseight',
                'desc' => 'Sepatu Lokal Original Untuk Running',
                'img' => 'images/products/C1hmejAbAztfuFcZQB7BfqL3a8NtZzuoI5libdv5.jpg',
                'category' => 'Fashion',
                'type' => 'warna_angka',
                'price' => 800000,
                'click_count' => 3,
                'variants' => [
                    ['color' => 'Putih', 'img' => 'images/products/C1hmejAbAztfuFcZQB7BfqL3a8NtZzuoI5libdv5.jpg', 'price' => 800000, 'sizes' => ['38','39','40','41','42']],
                    ['color' => 'Biru', 'img' => 'product_variants/lCjTOlpZ2mOYjMmVTzHHw5fLv6yp7uhPvVB3ElzP.jpg', 'price' => 800000, 'sizes' => ['38','39','40','41','42']],
                ],
            ],
            [
                'id' => 5,
                'store_id' => 1,
                'name' => 'Sepatu Pantofel Kulit',
                'desc' => 'Sepatu Kulit',
                'img' => 'images/products/9ZAutEVVa5dPnz0irXc1kJDOAWGq5ScGCgtSbRT4.webp',
                'category' => 'Fashion',
                'type' => 'warna_angka',
                'price' => 400000,
                'click_count' => 12,
                'variants' => [
                    ['color' => 'Hitam', 'img' => 'images/products/9ZAutEVVa5dPnz0irXc1kJDOAWGq5ScGCgtSbRT4.webp', 'price' => 400000, 'sizes' => ['38','39','40','41','42']],
                    ['color' => 'Coklat', 'img' => 'product_variants/NG621u4ZG2lQU8Qfqnfb4ZpLvQmVDuIc0SSfec6Y.webp', 'price' => 400000, 'sizes' => ['38','40','42']],
                ],
            ],
            [
                'id' => 6,
                'store_id' => 1,
                'name' => 'Vas Bunga',
                'desc' => 'Vas Bunga Untuk Mempercantik Rumahmu',
                'img' => 'images/products/zyk04vrxwCILSlhkfdAQvfloa8Y6tEsu9bXJTtU2.jpg',
                'category' => 'Kerajinan',
                'type' => 'tunggal',
                'price' => 100000,
                'click_count' => 3,
                'variants' => [],
            ],
            [
                'id' => 7,
                'store_id' => 1,
                'name' => 'Topi Pria',
                'desc' => null,
                'img' => 'images/products/Bqycc9NyN5H2BzWHqB0388Wuk99PONSbOTgZAWtE.jpg',
                'category' => 'Fashion',
                'type' => 'warna',
                'price' => 50000,
                'click_count' => 0,
                'variants' => [
                    ['color' => 'Hitam', 'img' => 'images/products/Bqycc9NyN5H2BzWHqB0388Wuk99PONSbOTgZAWtE.jpg', 'price' => 50000, 'sizes' => []],
                    ['color' => 'Putih', 'img' => 'product_variants/qcQlUDuxmFg74LqvvwlP2lOyBR0nrXOu4OSeJ64s.jpg', 'price' => 50000, 'sizes' => []],
                ],
            ],
            [
                'id' => 8,
                'store_id' => 2,
                'name' => 'Baju Lengan Panjang',
                'desc' => 'Baju Lengan panjang',
                'img' => 'product_variants/Z31mH5fxfa73aMPWKvnuumlNOhxhG1zFy5ztQ3No.jpg',
                'category' => 'Fashion',
                'type' => 'warna_huruf',
                'price' => 70000,
                'click_count' => 3,
                'variants' => [
                    ['color' => 'Coklat', 'img' => 'product_variants/Z31mH5fxfa73aMPWKvnuumlNOhxhG1zFy5ztQ3No.jpg', 'price' => 70000, 'sizes' => ['S','M','L','XL']],
                    ['color' => 'Biru', 'img' => 'product_variants/C8kvfMufioMMGRkRGG1e5cORgkJpidT4ClGbKYGh.jpg', 'price' => 70000, 'sizes' => ['S','M','L','XL','XXL']],
                ],
            ],
            [
                'id' => 9,
                'store_id' => 1,
                'name' => 'Sepatu Running',
                'desc' => 'Sepatu Untuk Running',
                'img' => 'images/products/ukSXZjlpDPHVrgkoyu35ZtzU84ke6vauzD49AXLy.jpg',
                'category' => 'Fashion',
                'type' => 'warna_angka',
                'price' => 600000,
                'click_count' => 1,
                'variants' => [
                    ['color' => 'Hitam', 'img' => 'images/products/ukSXZjlpDPHVrgkoyu35ZtzU84ke6vauzD49AXLy.jpg', 'price' => 600000, 'sizes' => ['38','39','40','41','42']],
                ],
            ],
            [
                'id' => 10,
                'store_id' => 1,
                'name' => 'Ransel Siswa Sekolah',
                'desc' => 'Ransel Untuk Sekolah',
                'img' => 'images/products/sK7NTMiwh9UqnGqJWD3jpX2aM3oNbcRyscUrijtp.jpg',
                'category' => 'Fashion',
                'type' => 'warna',
                'price' => 300000,
                'click_count' => 1,
                'variants' => [
                    ['color' => 'Biru', 'img' => 'images/products/sK7NTMiwh9UqnGqJWD3jpX2aM3oNbcRyscUrijtp.jpg', 'price' => 300000, 'sizes' => []],
                    ['color' => 'Pink', 'img' => 'product_variants/L5YoEH6HeKTI6Uw3udLpVBjuYGGhCYRrkTdylnb2.jpg', 'price' => 300000, 'sizes' => []],
                ],
            ],
            [
                'id' => 11,
                'store_id' => 2,
                'name' => 'Lovely Rattan',
                'desc' => null,
                'img' => 'images/products/kDmwFOKSoDQ18AK7h4CwmU8xVxxOiz6blxkhaDPz.jpg',
                'category' => 'Kerajinan',
                'type' => 'tunggal',
                'price' => 70000,
                'click_count' => 1,
                'variants' => [],
            ],
        ];

        foreach ($products as $p) {
            $product = Product::create([
                'id' => $p['id'],
                'store_id' => $p['store_id'],
                'name' => $p['name'],
                'desc' => $p['desc'],
                'img' => $p['img'],
                'category' => $p['category'],
                'type' => $p['type'],
                'price' => $p['price'],
                'click_count' => $p['click_count'],
            ]);

            // Hanya buat varian jika bukan tipe "tunggal"
            if ($p['type'] !== 'tunggal' && !empty($p['variants'])) {
                foreach ($p['variants'] as $v) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color' => $v['color'],
                        'img' => $v['img'],
                        'price' => $v['price'],
                        'sizes' => $v['sizes'],
                    ]);
                }
            }
        }
    }
}
