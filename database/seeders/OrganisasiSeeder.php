<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Wajib untuk field created_at, updated_at
use App\Models\TbMenu; // WAJIB: Tambahkan import model TbMenu untuk pencarian ID
use App\Models\TbMenuData; // WAJIB: Tambahkan import model TbMenuData

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // 1. CARI ID MENU 'Organisasi' secara dinamis (seperti NewsSeeder)
        $menuOrganisasi = TbMenu::where('nama', 'Organisasi')->first();

        if (!$menuOrganisasi) {
            // Berhenti jika menu 'Organisasi' tidak ditemukan (MenuSeeder mungkin belum jalan)
            throw new \Exception("Menu 'Organisasi' tidak ditemukan. Pastikan MenuSeeder sudah dijalankan.");
        }

        $menuIdOrganisasi = $menuOrganisasi->id; // Ambil ID dinamis dari database


        // CATATAN: Pastikan gambar-gambar ini (misalnya di /public/organisasi/) 
        // sudah ada di server Anda saat menjalankan seeder ini.
        $organisasiItems = [
            [
                'nama' => 'Dedie Abdul Rachim',
                'jabatan' => 'Pembina',
                // MENGGUNAKAN PATH LOKAL ANDA
                'img' => 'organisasi/Dedie_Abdu_Rachim,_Wali_Kota_Bogor_(2025).png', 
                'deskripsi' => 'Sebagai Wali Kota Bogor sekaligus Pembina, memberikan arahan strategis untuk kemajuan Dekranasda Kota Bogor.',
            ],
            [
                'nama' => 'Yantie Rachim',
                'jabatan' => 'Ketua Umum',
                // MENGGUNAKAN PATH LOKAL ANDA
                'img' => 'organisasi/ketua.png', 
                'deskripsi' => 'Bertanggung jawab sebagai pimpinan utama Dekranasda, mengawasi seluruh program kerja dan inisiatif.',
            ],
            [
                'nama' => 'Rahmat Hidayat',
                'jabatan' => 'Ketua Harian',
                // MENGGUNAKAN PATH LOKAL ANDA
                'img' => 'organisasi/ketua2.png', 
                'deskripsi' => 'Mendukung Ketua Umum dalam pelaksanaan program kerja sehari-hari, serta mengkoordinasikan bidang-bidang teknis.',
            ],
        
        ];

        $dataToInsert = [];
        foreach ($organisasiItems as $item) {
            // --- LOGIKA BARU: GABUNGKAN JABATAN DAN DESKRIPSI KE JSON STRING ---
            $contentJson = json_encode([
                [
                    'jabatan' => $item['jabatan'],
                    'deskripsi' => $item['deskripsi'],
                ]
            ]);
            // --------------------------------------------------------------------

            $dataToInsert[] = [
                'menu_id' => $menuIdOrganisasi, // Gunakan ID dinamis
                'jenis_konten' => 'organisasi', // Jenis konten baru untuk data struktur organisasi
                'title' => $item['nama'], // Nama menjadi Title
                'content' => $contentJson, // <=== KINI BERISI JSON STRING
                'img' => $item['img'],
                'date' => null, 
                
                'location' => null, // <=== DIKOSONGKAN (NULL) SESUAI PERMINTAAN
                'link' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Hanya masukkan jika belum ada data 'organisasi' di tabel
        if (DB::table('tb_menu_data')->where('jenis_konten', 'organisasi')->count() === 0) {
            DB::table('tb_menu_data')->insert($dataToInsert);
        }
    }
}
