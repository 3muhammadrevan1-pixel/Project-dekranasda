<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; 

class TbMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
         $now = Carbon::now();
        // 1. MATIKAN pemeriksaan Foreign Key untuk mengizinkan TRUNCATE
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus semua data dari tabel tb_menu
        DB::table('tb_menu')->truncate(); 

        // 2. Insert Menu Utama (parent_id = 0)
        DB::table('tb_menu')->insert([
            ['nama' => 'Beranda', 'parent_id' => 0, 'urutan' => 1, 'tipe' => 'statis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Tentang Kami', 'parent_id' => 0, 'urutan' => 2, 'tipe' => 'statis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Produk', 'parent_id' => 0, 'urutan' => 3, 'tipe' => 'dinamis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Berita', 'parent_id' => 0, 'urutan' => 4, 'tipe' => 'dinamis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Galeri', 'parent_id' => 0, 'urutan' => 5, 'tipe' => 'dinamis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Event', 'parent_id' => 0, 'urutan' => 6, 'tipe' => 'dinamis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Ambil ID dari menu 'Tentang Kami'
        $tentangKamiId = DB::table('tb_menu')->where('nama', 'Tentang Kami')->value('id');

        // 4. Insert Sub-menu
        if ($tentangKamiId) {
            DB::table('tb_menu')->insert([
                [
                    'nama' => 'Sejarah',
                    'parent_id' => $tentangKamiId, 
                    'urutan' => 1, 'tipe' => 'statis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()
                ],
                [
                    'nama' => 'Organisasi',
                    'parent_id' => $tentangKamiId, 
                    'urutan' => 2, 'tipe' => 'dinamis', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()
                ],
            ]);
        }
        
        // 5. NYALAKAN KEMBALI pemeriksaan Foreign Key setelah proses selesai
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}