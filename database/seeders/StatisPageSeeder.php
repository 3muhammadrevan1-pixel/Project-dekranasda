<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatisPage;

class StatisPageSeeder extends Seeder
{
    public function run(): void
    {
        // ====== VISI, MISI, FOKUS ======
        StatisPage::create([
            'judul' => 'Visi, Misi, dan Fokus',
            'slug' => 'visi-misi',
            'konten' => json_encode([
                [
                    'title' => 'Visi',
                    'text' => 'Menjadi pusat pengembangan kerajinan lokal kreatif dan berkelanjutan.'
                ],
                [
                    'title' => 'Misi',
                    'text' => 'Memberdayakan pengrajin, memfasilitasi pemasaran, dan melestarikan budaya.'
                ],
                [
                    'title' => 'Fokus',
                    'text' => 'Anyaman, batik, ukiran kayu, dan produk kreatif khas Bogor.'
                ]
            ])
        ]);
        // ====== PROGRAM KERJA ======
        StatisPage::create([
            'judul' => 'Program Kerja',
            'slug' => 'program-kerja',
            'konten' => json_encode([
                [
                    "bidang" => "Kesekretariatan",
                    "program" => [
                        ["judul" => "Fasilitasi korespondensi", "deskripsi" => "Melaksanakan pelayanan surat-menyurat Dekranasda Kota Bogor baik internal maupun eksternal."],
                        ["judul" => "Fasilitasi rapat-rapat", "deskripsi" => "Pelayanan rapat pengurus maupun anggota Dekranasda."],
                        ["judul" => "Fasilitasi penyusunan laporan", "deskripsi" => "Menyusun laporan tahun 2024 dan 2025 serta Program Kerja 2025."],
                        ["judul" => "Gathering pengurus dan pengrajin", "deskripsi" => "Melaksanakan gathering antara pengurus dan pengrajin binaan."]
                    ]
                ],
                [
                    "bidang" => "Bidang Pendanaan & Manajemen Usaha",
                    "program" => [
                        ["judul" => "Pembuatan Proposal CoE", "deskripsi" => "Proposal berisi event, deskripsi, dan pembiayaan untuk calon mitra."],
                        ["judul" => "Forum TJSL & BUMD", "deskripsi" => "Menjodohkan pengrajin menjadi mitra binaan BUMN/BUMD."],
                        ["judul" => "Bogor Inovation Award 2025", "deskripsi" => "Penerapan hasil inovasi bagi pengrajin."],
                        ["judul" => "Pameran & Promosi", "deskripsi" => "INACRAFT, PKJB, Ramadhan Fair, promosi Art Space dan Abon Mama."]
                    ]
                ],
                [
                    "bidang" => "Bidang Promosi & Kerjasama",
                    "program" => [
                        ["judul" => "Pameran INACRAFT & PKJB", "deskripsi" => "Promosi dan kerja sama UMKM Kota Bogor."],
                        ["judul" => "Program ABON MAMA", "deskripsi" => "Agregator bisnis online mahasiswa magang untuk UMKM."],
                        ["judul" => "Promosi Art Space & Ramadhan Fair", "deskripsi" => "Meningkatkan jumlah pengunjung pusat pelatihan."],
                        ["judul" => "Kerja sama pendidikan & magang", "deskripsi" => "Katalog digital, SOP magang, dan lowongan magang."]
                    ]
                ],
                [
                    "bidang" => "Bidang Humas & Publikasi",
                    "program" => [
                        ["judul" => "Konten Media Sosial", "deskripsi" => "Menyiapkan konten kegiatan Dekranasda di media sosial."],
                        ["judul" => "Publikasi Media Massa", "deskripsi" => "Advertorial, film, video di media cetak, online, dan videotron."],
                        ["judul" => "Dokumentasi kunjungan", "deskripsi" => "Publikasi kunjungan tamu Dekranasda."],
                        ["judul" => "Sosialisasi UMKM & HKI", "deskripsi" => "Workshop tematik, sertifikasi kompetensi, pendampingan HKI."]
                    ]
                ],
                [
                    "bidang" => "Bidang Daya Saing & Kreatifitas Produk",
                    "program" => [
                        ["judul" => "Pendampingan HKI & SIINAS", "deskripsi" => "Pendaftaran HKI Merek dan SIINAS."],
                        ["judul" => "Bimbingan teknis & desain", "deskripsi" => "Meningkatkan kualitas & diversifikasi produk kerajinan."],
                        ["judul" => "Kunjungan ke IDDC", "deskripsi" => "Belajar dari Indonesia Design Development Craft."],
                        ["judul" => "Lomba Produk Unggulan", "deskripsi" => "Kompetisi meningkatkan kualitas produk kerajinan."]
                    ]
                ]
            ])
        ]);

        // ====== SEJARAH ======
        StatisPage::create([
            'judul' => 'Sejarah Perkembangan',
            'slug' => 'sejarah',
            'konten' => json_encode([
                [
                    'title' => 'Kerajinan sebagai Bagian Budaya',
                    'text' => 'Kerajinan sebagai suatu perwujudan perpaduan ketrampilan untuk menciptakan suatu karya
                                dan nilai keindahan, merupakan bagian yang tidak terpisahkan dari suatu kebudayaan. Kerajinan tersebut tumbuh melalui proses waktu berabad-abad.
                                Tumbuh kembang maupun laju dan merananya kerajinan
                                sebagai warisan yang turun temurun tergantung dari beberapa faktor. Di antara faktor-faktor yang berpengaruh adalah
                                transformasi masyarakat yang disebabkan oleh teknologi yang semakin modern, minat dan penghargaan masyarakat terhadap barang kerajinan
                                 dan tetap mumpuninya para perajin itu sendiri,
                                baik dalam menjaga mutu dan kreativitas maupun dalam penyediaan produk kerajinan secara berkelanjutan.',
                    'image' => 'assets/d1.jpg'
                ],
                [
                    'title' => 'Arti Penting Industri Kerajinan',
                    'text' => 'Industri kerajinan Dekranasda Kota Bogor berperan penting dalam melestarikan budaya dan mendorong pertumbuhan ekonomi kreatif.
                                Melalui pembinaan dan inovasi, Dekranasda menjadi wadah bagi perajin untuk meningkatkan kualitas produk, memperluas pemasaran,
                                serta membuka peluang usaha yang berdampak pada kesejahteraan masyarakat.',
                    'image' => 'assets/d2.webp'
                ],
                [
                    'title' => 'Latar Belakang Terbentuknya Dekranasda',
                    'text' => 'Dekranasda lahir dari kesadaran akan pentingnya melestarikan kerajinan tradisional sebagai bagian dari warisan budaya bangsa.
                                Perubahan zaman dan perkembangan teknologi membuat kerajinan perlu dibina agar tetap bertahan sekaligus mampu bersaing di pasar modern. Karena itu,
                                dibentuklah Dewan Kerajinan Nasional dan Dekranasda di tingkat daerah sebagai wadah pembinaan, pelestarian, serta pengembangan
                                 industri kerajinan yang juga berperan dalam meningkatkan kesejahteraan para perajin.',
                    'image' => 'assets/d3.jpg'
                ],
                
                [
                    'title' => 'Berdirinya DEKRANASDA',
                    'text' => 'Dewan Kerajinan Nasional (Dekranas) resmi berdiri pada 3 Maret 1980 sebagai wadah pelestarian dan pengembangan kerajinan nusantara.
                                Untuk memperkuat perannya di daerah, dibentuklah Dewan Kerajinan Nasional Daerah (Dekranasda) di setiap provinsi dan kabupaten/kota, termasuk Kota Bogor,
                                yang berfungsi membina perajin lokal, meningkatkan kualitas produk, serta memperluas pemasaran kerajinan daerah.',
                    'image' => 'assets/d4.jpeg'
                ]
            ])
        ]);
    }
}
