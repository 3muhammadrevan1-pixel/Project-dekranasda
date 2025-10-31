<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TbMenu; // WAJIB: Tambahkan import model TbMenu untuk pencarian ID
use App\Models\TbMenuData; // WAJIB: Tambahkan import model TbMenuData

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. CARI ID MENU 'Berita' secara dinamis
        $menuBerita = TbMenu::where('nama', 'Berita')->first();

        if (!$menuBerita) {
            // Berhenti jika menu 'Berita' tidak ditemukan (MenuSeeder mungkin belum jalan)
            throw new \Exception("Menu 'Berita' tidak ditemukan. Pastikan MenuSeeder sudah dijalankan.");
        }

        $menuIdBerita = $menuBerita->id; // Ambil ID dinamis dari database

        // Hapus semua berita lama sebelum menyisipkan yang baru (opsional)
        // TbMenuData::where('jenis_konten', 'berita')->delete();

        $newsItems = [
            [
                'title' => 'Pengurus Dekranasda Kota Bogor 2025–2030 Resmi Dilantik, Fokus pada Digitalisasi dan Pengembangan UMKM',
                'img' => 'berita/brt1.png',
                'date' => '2025-08-20',
                'content' => 'Wakil Wali Kota Bogor, Jenal Mutaqin, menekankan bahwa fokus utama pengurus Dekranasda periode 2025-2030 adalah mendorong UMKM lokal untuk bertransformasi ke platform digital. Pelantikan ini diharapkan menjadi momentum kebangkitan ekonomi kreatif di Kota Bogor, dengan produk-produk kerajinan yang siap bersaing secara nasional maupun internasional.',
                'location' => 'Bogor'
            ],
            [
                'title' => 'Pererat Silaturahmi, Yantie Rachim Sambut Rombongan GOW dan TP PKK Tangerang Selatan',
                'img' => 'berita/brt2.jpg',
                'date' => '2025-08-25',
                'content' => 'Dekranasda Kota Bogor menerima kunjungan rombongan Gabungan Organisasi Wanita (GOW) dan Tim Penggerak PKK dari Tangerang Selatan. Kunjungan ini bertujuan untuk saling berbagi pengalaman dan praktik terbaik dalam pemberdayaan perempuan serta pengembangan produk kerajinan daerah. Acara diisi dengan dialog interaktif dan kunjungan ke Dekranasda Artspace.',
                'location' => 'Bogor Timur'
            ],
            [
                'title' => 'Dekranasda Kota Bogor Bidik Batik Bogor Bisa Mendunia',
                'img' => 'berita/brt3.jpg',
                'date' => '2025-04-27',
                'content' => 'Ketua Dekranasda Kota Bogor Yantie Rachim menyampaikan mimpinya untuk membawa Batik Bogor menembus pasar internasional. Upaya ini dilakukan melalui peningkatan kualitas desain, penggunaan bahan baku ramah lingkungan, dan partisipasi aktif dalam pameran-pameran internasional. Target utama adalah menjadikan motif Kujang dan Rusa sebagai ikon kerajinan dunia.',
                'location' => 'Bogor'
            ],
        ];

        $dataToInsert = [];
        foreach ($newsItems as $item) {
            $dataToInsert[] = [
                'menu_id' => $menuIdBerita, // Gunakan ID dinamis
                'jenis_konten' => 'berita', // Wajib untuk filtering
                'title' => $item['title'],
                'content' => $item['content'],
                'img' => $item['img'],
                'date' => Carbon::parse($item['date']), // Parsing tanggal
                'location' => $item['location'],
                'link' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Hanya masukkan jika belum ada data 'berita' di tabel
        if (DB::table('tb_menu_data')->where('jenis_konten', 'berita')->count() === 0) {
            DB::table('tb_menu_data')->insert($dataToInsert);
        }
    }
}
