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
                'desc' => 'Loji Craft adalah brand fashion lokal yang mengusung keindahan dan filosofi batik sebagai bagian dari gaya hidup modern. Kami berkomitmen menghadirkan baju batik berkualitas tinggi dengan sentuhan desain kontemporer tanpa meninggalkan nilai-nilai tradisi Nusantara.

                            Nama Produk: Baju Batik Loji Craft

                            Kategori: Fashion – Batik Pria & Wanita

                            Bahan: Katun premium / viscose / dobby (nyaman dan adem dipakai)

                            Teknik: Cap dan tulis, dengan pewarnaan ramah lingkungan

                            Desain: Modern dan elegan, cocok untuk acara formal maupun kasual

                            Ukuran: S – XXL

                            Keunggulan:

                            Motif eksklusif buatan tangan pengrajin lokal

                            Jahitan kuat dan detail presisi

                            Warna tahan lama dan tidak mudah luntur

                            Nyaman dipakai seharian',
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
                'desc' => 'Jaket Tracktop Parasut – Ringan, Stylish, dan Tahan Angin!

                        Deskripsi Produk:
                        Tampil sporty dan tetap nyaman di segala aktivitas dengan Jaket Tracktop Parasut berbahan ringan dan tahan angin.
                        Terbuat dari bahan parasut premium yang tidak mudah kusut, cepat kering, dan nyaman dipakai, jaket ini cocok untuk digunakan saat olahraga, bepergian, atau aktivitas outdoor.

                        Desainnya modern dengan resleting depan penuh, saku fungsional, dan pilihan warna keren Hitam, Coklat, dan Biru. Tersedia dalam ukuran S hingga XXL yang pas untuk semua postur tubuh.

                        Keunggulan Produk:

                        ✅ Bahan parasut premium – ringan, adem, dan tahan angin

                        ✅ Desain sporty & stylish, cocok untuk segala aktivitas

                        ✅ Cepat kering dan mudah dibersihkan

                        ✅ Warna elegan: Hitam, Coklat, Biru

                        ✅ Ukuran lengkap: S – XXL

                        ✅ Cocok untuk pria maupun wanita (unisex)

                        Spesifikasi:

                        Bahan: Parasut premium (water repellent & windproof)

                        Warna: Hitam / Coklat / Biru

                        Ukuran: S, M, L, XL, XXL

                        Model: Tracktop sporty zipper full

                        Fitur: Saku kanan kiri, karet pinggang & pergelangan',
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
                'desc' => 'Kemeja Wanita – Elegan, Nyaman, dan Tampil Anggun Setiap Hari!
                            Deskripsi Produk:
                            Tampil rapi dan stylish dengan Kemeja Wanita berbahan lembut dan adem, cocok untuk berbagai kesempatan — mulai dari kerja, kuliah, hingga acara santai.
                            Dibuat dari bahan katun premium yang halus di kulit dan mudah menyerap keringat, memberikan kenyamanan maksimal sepanjang hari.

                            Desainnya simpel namun elegan, tersedia dalam dua warna cantik Putih dan Pink, serta ukuran lengkap S hingga XL, pas untuk berbagai bentuk tubuh.

                            Keunggulan Produk:

                            ✅ Bahan katun premium – adem, lembut, dan tidak mudah kusut

                            ✅ Desain elegan & modern, cocok untuk formal maupun casual look

                            ✅ Warna feminin: Putih & Pink

                            ✅ Jahitan rapi dan potongan fit yang menawan

                            ✅ Ukuran lengkap: S, M, L, XL

                            Spesifikasi:

                            Bahan: Katun Combed / Linen lembut

                            Warna: Putih / Pink

                            Ukuran: S, M, L, XL

                            Model: Kemeja lengan panjang wanita

                            Cocok untuk: Kerja, kuliah, meeting, dan acara santai',
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
                'desc' => 'Sepatu Running Ortuseight – Ringan, Kuat, dan Nyaman untuk Setiap Langkah!

                            Deskripsi Produk:
                            Rasakan performa maksimal dengan Sepatu Running Lokal Ortuseight, pilihan tepat untuk kamu yang aktif dan sporty!
                            Dirancang dengan teknologi lokal berkualitas tinggi, sepatu ini menggabungkan kenyamanan, ketahanan, dan desain modern untuk mendukung setiap aktivitas lari dan olahraga harianmu.

                            Terbuat dari bahan mesh breathable yang menjaga kaki tetap sejuk, serta sol karet anti slip yang memberikan grip kuat di berbagai permukaan. Tersedia dalam dua warna stylish — Putih dan Biru, dengan ukuran 38–42 yang pas dan nyaman dipakai.

                            Keunggulan Produk:

                            ✅ Brand lokal berkualitas tinggi – Ortuseight Original

                            ✅ Desain sporty, ringan, dan fleksibel

                            ✅ Bahan mesh breathable – menjaga sirkulasi udara di kaki

                            ✅ Sol karet anti slip & empuk – nyaman untuk lari jarak jauh

                            ✅ Varian warna: Putih & Biru

                            ✅ Ukuran lengkap: 38 – 42

                            Spesifikasi:

                            Brand: Ortuseight

                            Model: Running / Sport Shoes

                            Bahan atas: Mesh dan kain sintetis premium

                            Sol: Rubber anti slip + bantalan empuk

                            Warna: Putih / Biru

                            Ukuran: 38 – 42',
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
                'desc' => 'Sepatu Pantofel Kulit Pria – Elegan, Nyaman, dan Berkelas

                        Deskripsi Produk:
                        Tingkatkan penampilan formal Anda dengan Sepatu Pantofel Kulit Pria yang dirancang untuk memberikan kesan profesional dan elegan di setiap langkah.
                        Dibuat dari kulit sintetis berkualitas tinggi, sepatu ini memiliki permukaan halus, lentur, dan mudah dibersihkan. Desain klasik dengan detail rapi menjadikannya pilihan sempurna untuk bekerja, acara formal, atau pesta.

                        Tersedia dalam dua warna elegan — Hitam dan Coklat — serta ukuran 38 hingga 42, yang nyaman dan pas di kaki.

                        Keunggulan Produk:

                        ✅ Terbuat dari kulit sintetis premium, kuat dan tahan lama

                        ✅ Desain elegan, cocok untuk acara formal & kantor

                        ✅ Sol empuk dan anti slip untuk kenyamanan sepanjang hari

                        ✅ Varian warna: Hitam dan Coklat

                        ✅ Ukuran lengkap: 38 – 42

                        Spesifikasi:

                        Bahan luar: Kulit sintetis berkualitas tinggi

                        Bahan dalam: Kain lembut dan breathable

                        Sol: Karet anti slip


                        Warna: Hitam / Coklat

                        Ukuran: 38 – 42',
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
                'desc' => 'Vas Bunga Beling – Sentuhan Elegan untuk Dekorasi Rumah Anda

                            Deskripsi Produk:
                            Hadirkan nuansa elegan di ruangan Anda dengan Vas Bunga Berbahan Beling (Kaca) yang memancarkan keindahan dan kesederhanaan alami.
                            Dibuat dari bahan beling berkualitas tinggi dengan finishing halus dan mengkilap, vas ini menampilkan tampilan modern dan estetik yang cocok untuk ruang tamu, meja makan, kantor, hingga kafe.

                            Cocok untuk menampung bunga segar maupun bunga hias, vas ini juga dapat digunakan sebagai dekorasi standalone yang mempercantik sudut ruangan Anda.

                            Keunggulan Produk:

                            ✅ Terbuat dari bahan beling (kaca) tebal dan kuat

                            ✅ Desain elegan & minimalis, cocok untuk berbagai gaya interior

                            ✅ Permukaan halus, mudah dibersihkan

                            ✅ Cocok untuk bunga segar atau artificial

                            ✅ Dapat digunakan sebagai dekorasi meja, rak, atau hadiah cantik

                            Spesifikasi:

                            Bahan: Beling / Kaca tebal berkualitas tinggi

                            Ukuran: ± 30 cm x 50 cm



                            Berat: ± 800 gram

                            Finishing: Glossy halus, bening elegan',
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
                'desc' => 'Topi Casual Unisex – Simpel, Keren, dan Nyaman Dipakai!

                            Deskripsi Produk:
                            Lengkapi gaya harianmu dengan Topi Casual Unisex yang modis dan fungsional!
                            Terbuat dari bahan katun twill premium yang lembut, ringan, dan breathable, topi ini nyaman digunakan di segala aktivitas — mulai dari jalan santai, olahraga, hingga traveling.

                            Desainnya simpel namun elegan, dengan pilihan warna Hitam dan Putih yang mudah dipadukan dengan berbagai outfit. Cocok untuk pria maupun wanita yang ingin tampil stylish sekaligus terlindungi dari panas matahari.

                            Keunggulan Produk:

                            ✅ Bahan katun twill berkualitas tinggi – adem & nyaman dipakai

                            ✅ Desain simpel dan trendi

                            ✅ Varian warna elegan: Hitam & Putih

                            ✅ Dapat disesuaikan dengan tali belakang (adjustable strap)

                            ✅ Cocok untuk aktivitas outdoor dan casual look

                            Spesifikasi:

                            Bahan: Katun Twill Premium

                            Warna: Hitam / Putih

                            Model: Baseball Cap (Unisex)

                            Berat: ±150 gram',
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
                'desc' => 'Baju Lengan Panjang – Stylish, Nyaman, dan Serbaguna!

                    Deskripsi Produk:
                    Tampil keren dan tetap nyaman dengan Baju Lengan Panjang yang cocok untuk segala aktivitas, baik santai maupun semi-formal.
                    Dibuat dari bahan katun premium yang lembut dan adem di kulit, baju ini memberikan kenyamanan maksimal sepanjang hari. Desainnya simpel namun elegan, mudah dipadukan dengan celana jeans, chino, atau rok untuk tampilan kasual maupun rapi.

                    Dengan potongan modern dan jahitan rapi, Baju Lengan Panjang ini cocok untuk pria maupun wanita yang ingin tampil stylish tanpa mengorbankan kenyamanan.

                    Keunggulan Produk:

                    ✅ Bahan katun premium – lembut, adem, dan menyerap keringat

                    ✅ Desain modern & kasual, cocok untuk berbagai kesempatan

                    ✅ Jahitan rapi dan kuat, tidak mudah melar

                    ✅ Nyaman dipakai seharian

                    ✅ Tersedia dalam berbagai ukuran

                    Spesifikasi:

                    Bahan: Katun Combed / Linen / Rayon

                    Ukuran: S, M, L, XL, XXL

                    Warna: Abu, Biru

                    Model: Unisex / Regular fit

                    Perawatan: Cuci dengan air dingin, jangan gunakan pemutih, dan setrika dengan suhu sedang',
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
                'desc' => 'Sepatu Running – Ringan, Nyaman, dan Siap Temani Setiap Langkah!

                            Deskripsi Produk:
                            Tingkatkan performa lari Anda dengan Sepatu Running yang dirancang khusus untuk kenyamanan dan ketahanan maksimal.
                            Menggunakan bahan mesh breathable yang membuat kaki tetap sejuk, serta sol karet anti slip yang memberikan cengkeraman kuat di berbagai medan. Desainnya modern, ringan, dan fleksibel, cocok untuk aktivitas olahraga, jogging, gym, maupun pemakaian harian.

                            Dengan teknologi shock absorber di bagian sol, sepatu ini membantu mengurangi tekanan pada kaki dan sendi saat berlari, sehingga Anda bisa bergerak lebih cepat dan nyaman tanpa rasa lelah berlebih.

                            Keunggulan Produk:

                            ✅ Desain sporty dan modern

                            ✅ Bahan mesh berkualitas tinggi, ringan dan mudah bernapas

                            ✅ Sol karet anti slip untuk keamanan maksimal

                            ✅ Insole empuk dan fleksibel, nyaman dipakai seharian

                            ✅ Cocok untuk jogging, gym, olahraga, dan aktivitas outdoor

                            Spesifikasi:

                            Bahan atas: Mesh & kain sintetis premium

                            Sol luar: Karet ringan anti slip

                            Insole: Empuk dan breathable

                            Ukuran: 38 – 42

                            Warna: Hitam / Abu / Biru (tergantung varian tersedia)

                            Model: Running shoes unisex',
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
                'desc' => 'Deskripsi Produk:
                            Buat aktivitas sekolah si kecil semakin semangat dengan Ransel Anak Sekolah yang lucu dan fungsional ini!
                            Terbuat dari bahan nylon premium yang kuat, ringan, dan tahan air, ransel ini dirancang khusus agar nyaman digunakan anak-anak setiap hari. Desainnya menarik dengan warna cerah biru dan pink, cocok untuk anak laki-laki maupun perempuan.

                            Memiliki ruang penyimpanan luas untuk buku, botol minum, bekal, serta perlengkapan sekolah lainnya. Dilengkapi tali bahu empuk dan dapat disesuaikan agar tidak membuat bahu pegal saat digunakan dalam waktu lama.

                            Keunggulan Produk:

                            ✅ Bahan kuat, ringan, dan tahan air

                            ✅ Desain lucu dan warna cerah (Biru & Pink)

                            ✅ Tali bahu empuk dan bisa disesuaikan

                            ✅ Banyak kantong penyimpanan – muat buku, alat tulis, dan botol minum

                            ✅ Cocok untuk anak TK, SD, hingga kelas awal

                            Spesifikasi:

                            Bahan: Nylon Oxford premium (water resistant)

                            Ukuran: ± 38 cm x 28 cm x 12 cm

                            Warna: Biru / Pink

                            Berat: ± 500 gram

                            Kompartemen: 1 ruang utama + 2 saku depan + 2 saku samping

                            Penutup: Resleting kuat & halus',
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
