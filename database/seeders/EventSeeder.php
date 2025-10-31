<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TbMenu; 
use App\Models\TbMenuData; 

class EventSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. CARI ID MENU 'Event' secara dinamis
        $menuEvent = TbMenu::where('nama', 'Event')->first();

        if (!$menuEvent) {
            throw new \Exception("Menu 'Event' tidak ditemukan. Pastikan MenuSeeder sudah dijalankan.");
        }

        $menuIdEvent = $menuEvent->id; 

        // 2. HAPUS DATA EVENT LAMA untuk mencegah duplikasi saat seeder dijalankan ulang
        TbMenuData::where('jenis_konten', 'event')->delete();
        
        $events = [
            [
                "title" => "Pelantikan Pengurus Dekranasda Kota Bogor",
                "img" => "event/event1.webp", 
                "desc" => "Wakil Wali Kota Bogor melantik pengurus baru Dekranasda yang fokus pada pengembangan UMKM dan digitalisasi.",
                "date" => "2025-08-28", // Hanya menggunakan satu kolom tanggal (YYYY-MM-DD)
                "lokasi" => "Paseban Sri Baduga, Balai Kota Bogor",
                "link" => "https://satujabar.com/pengurus-dekranasda-kota-bogor-2025-2030-resmi-dilantik-fokus-umkm-dan-digitalisasi/"
            ],
            [
                "title" => "Pameran Karya Kreatif Jawa Barat (KKJB) & Pekan Kerajinan Jawa Barat (PKJB) 2025",
                "img" => "event/event2.jpeg",
                "desc" => "Menampilkan produk unggulan UMKM lokal Kota Bogor dan mengikuti Dekranasda Jabar Awards.",
                "date" => "2025-07-17",
                "lokasi" => "Trans Studio Mall, Kota Bandung",
                "link" => "https://indag.jabarprov.go.id/postingan/pkjb-2025-sukses-digelar-kerajinan-jabar-tampil-memikat-lewat-pameran-dan-promosi-digital-6889e3bb1a2a827d6d6e5a07"
            ],
            [
                "title" => "Promo Gebyar Merdeka di Dekranasda Artspace",
                "img" => "event/event3.jpeg",
                "desc" => "Menampilkan berbagai produk kreatif khas Kota Bogor dengan promo spesial.",
                "date" => "2025-08-17",
                "lokasi" => "Mal Lippo Kebon Raya",
                "link" => "https://www.instagram.com/p/DNiDNkFhRzE/"
            ],
            [
                "title" => "Festival Bedug Kota Bogor",
                "img" => "event/event4.webp",
                "desc" => "Festival menampilkan 150 booth UMKM, bazar kuliner, dan pertunjukan budaya.",
                "date" => "2025-08-17",
                "lokasi" => "Jalan Surya Kencana",
                "link" => "https://www.instagram.com/reel/DKwEmUiB6t7/"
            ],
            [
                "title" => "Partisipasi dalam Sunda Karsa Fest 2025",
                "img" => "event/event5.jpeg",
                "desc" => "Menampilkan produk kerajinan dan inovasi lokal dari Dekranasda Kota Bogor.",
                "date" => "2025-08-17",
                "lokasi" => "Trans Studio Mall, Kota Bandung",
                "link" => "https://www.instagram.com/p/DMVQECbS3Yp/"
            ],
        ];

        $dataToInsert = [];
        foreach ($events as $event) {
            $dataToInsert[] = [
                'menu_id' => $menuIdEvent, 
                'jenis_konten' => 'event', 
                'title' => $event['title'],
                'content' => $event['desc'], 
                'img' => $event['img'],
                // Carbon::parse akan mengkonversi string YYYY-MM-DD menjadi objek tanggal database
                'date' => Carbon::parse($event['date']), 
                'location' => $event['lokasi'], 
                'link' => $event['link'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 3. SISIPKAN DATA BARU
        DB::table('tb_menu_data')->insert($dataToInsert);
    }
}
