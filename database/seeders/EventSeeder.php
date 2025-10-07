<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $events = [
            [
                "title" => "Pelantikan Pengurus Dekranasda Kota Bogor",
                "img" => "storage/event/event1.webp",
                "desc" => "Wakil Wali Kota Bogor melantik pengurus baru Dekranasda yang fokus pada pengembangan UMKM dan digitalisasi.",
                "date" => "28 Agustus 2025",
                "lokasi" => "Paseban Sri Baduga, Balai Kota Bogor",
                "link" => "https://satujabar.com/pengurus-dekranasda-kota-bogor-2025-2030-resmi-dilantik-fokus-umkm-dan-digitalisasi/"
            ],
            [
                "title" => "Pameran Karya Kreatif Jawa Barat (KKJB) & Pekan Kerajinan Jawa Barat (PKJB) 2025",
                "img" => "storage/event/event2.jpeg",
                "desc" => "Menampilkan produk unggulan UMKM lokal Kota Bogor dan mengikuti Dekranasda Jabar Awards.",
                "date" => "17–18 Juli 2025",
                "lokasi" => "Trans Studio Mall, Kota Bandung",
                "link" => "https://indag.jabarprov.go.id/postingan/pkjb-2025-sukses-digelar-kerajinan-jabar-tampil-memikat-lewat-pameran-dan-promosi-digital-6889e3bb1a2a827d6d6e5a07"
            ],
            [
                "title" => "Promo Gebyar Merdeka di Dekranasda Artspace",
                "img" => "storage/event/event3.jpeg",
                "desc" => "Menampilkan berbagai produk kreatif khas Kota Bogor dengan promo spesial.",
                "date" => "17–31 Agustus 2025",
                "lokasi" => "Mal Lippo Kebon Raya",
                "link" => "https://www.instagram.com/p/DNiDNkFhRzE/"
            ],
            [
                "title" => "Festival Bedug Kota Bogor",
                "img" => "storage/event/event4.webp",
                "desc" => "Festival menampilkan 150 booth UMKM, bazar kuliner, dan pertunjukan budaya.",
                "date" => "27 Maret 2025",
                "lokasi" => "Jalan Surya Kencana",
                "link" => "https://www.instagram.com/reel/DKwEmUiB6t7/"
            ],
            [
                "title" => "Partisipasi dalam Sunda Karsa Fest 2025",
                "img" => "storage/event/event5.jpeg",
                "desc" => "Menampilkan produk kerajinan dan inovasi lokal dari Dekranasda Kota Bogor.",
                "date" => "Juli 2025",
                "lokasi" => "Trans Studio Mall, Kota Bandung",
                "link" => "https://www.instagram.com/p/DMVQECbS3Yp/"
            ],
            [
                "title" => "Pameran dan Workshop di Dekranasda Artspace",
                "img" => "storage/event/event6.jpeg",
                "desc" => "Pusat pelatihan kerajinan dan wirausahawan baru di Kota Bogor, dengan pameran dan workshop.",
                "date" => "Juni–Agustus 2025",
                "lokasi" => "Dekranasda Artspace, Kota Bogor",
                "link" => "https://www.instagram.com/dekranasda.kotabogor/"
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
