<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
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
        ];

        foreach ($data as $bidang) {
            foreach ($bidang['program'] as $prog) {
                Program::create([
                    'bidang' => $bidang['bidang'],
                    'judul' => $prog['judul'],
                    'deskripsi' => $prog['deskripsi'],
                ]);
            }
        }
    }
}
