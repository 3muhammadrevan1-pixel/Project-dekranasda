<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('tb_menu')->insert([
            [
                'nama' => 'Beranda',
                'parent_id' => 0,
                'urutan' => 1,
                'jenis_konten' => 'statis',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Tentang Kami',
                'parent_id' => 0,
                'urutan' => 2,
                'jenis_konten' => 'statis',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Sejarah',
                'parent_id' => 2,
                'urutan' => 1,
                'jenis_konten' => 'statis',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Organisasi',
                'parent_id' => 2,
                'urutan' => 2,
                'jenis_konten' => 'organisasi',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Produk',
                'parent_id' => 0,
                'urutan' => 3,
                'jenis_konten' => 'statis',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Berita',
                'parent_id' => 0,
                'urutan' => 4,
                'jenis_konten' => 'dinamis',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Galeri',
                'parent_id' => 0,
                'urutan' => 5,
                'jenis_konten' => 'media',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Event',
                'parent_id' => 0,
                'urutan' => 6,
                'jenis_konten' => 'dinamis',
                'tipe' => 'statis',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
