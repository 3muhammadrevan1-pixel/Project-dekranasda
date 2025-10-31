<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TbMenu;
use App\Models\TbMenuData;
use Carbon\Carbon;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Cari ID Menu 'Galeri' secara dinamis
        $menuGaleri = TbMenu::where('nama', 'Galeri')->first();

        if (!$menuGaleri) {
            // Berhenti jika menu 'Galeri' tidak ditemukan
            throw new \Exception("Menu 'Galeri' tidak ditemukan. Pastikan MenuSeeder sudah dijalankan.");
        }

        $galeriMenuId = $menuGaleri->id; // Mengambil ID menu 'Galeri'

        // Data Gambar Galeri (Hanya path relatif)
        $images = [
            'galeri/g1.jpg',
            'galeri/g2.webp',
            'galeri/g3.jpg',
            'galeri/g4.jpg',
            'galeri/g5.jpeg',
            'galeri/g6.jpeg',
            'galeri/g7.webp',
            'galeri/g8.jpg',
            'galeri/g9.webp',
        ];

        // WAJIB: Hapus semua data galeri lama untuk mencegah duplikasi (Idempotency)
        TbMenuData::where('jenis_konten', 'galeri')->delete();

        // 2. Loop dan buat data untuk disisipkan (Hanya fokus pada 'img')
        $dataToInsert = [];
        foreach ($images as $img) {
            $dataToInsert[] = [
                'menu_id' => $galeriMenuId,
                'jenis_konten' => 'galeri',
                'img' => $img, // Awalan 'storage/' ditambahkan di sini

                // FIX: Menggunakan string kosong ('') BUKAN NULL, karena kolom 'title' adalah NOT NULL.
                'title' => null,
                'content' => null,

                'location' => null,
                'date' => null,
                'link' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Sisipkan semua data baru secara massal
        DB::table('tb_menu_data')->insert($dataToInsert);
    }
}
