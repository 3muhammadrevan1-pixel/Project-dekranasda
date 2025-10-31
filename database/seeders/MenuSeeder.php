<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Kosongkan tabel untuk memastikan data baru masuk tanpa konflik
        DB::table('tb_menu')->delete(); 

        // Menu INDUK (Parent)
        // ID sudah diurutkan dan tidak ada duplikasi. Menu 'PROGRAM' telah dihapus.
        // ===========================================

        $parent_menus = [
            // ID 1: Beranda
            [
                'id' => 1, 
                'nama' => 'Beranda',
                'urutan' => 0, // Urutan paling awal
                'tipe' => 'statis', 
                'status' => 'aktif', 
                'parent_id' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // ID 2: Tentang Kami (ID DARI 3 LAMA DIPINDAHKAN KE 2)
            [
                'id' => 2, 
                'nama' => 'Tentang Kami',
                'urutan' => 1,
                'tipe' => 'statis', 
                'status' => 'aktif', 
                'parent_id' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // ID 3: Berita (ID DARI 3 LAMA DIPINDAHKAN KE 3, URUTAN BERUBAH)
            [
                'id' => 3, 
                'nama' => 'Berita',
                'urutan' => 2,
                'tipe' => 'dinamis', 
                'status' => 'aktif',
                'parent_id' => 0, 
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // ID 4: Galeri (URUTAN BERUBAH)
            [
                'id' => 4, 
                'nama' => 'Galeri',
                'urutan' => 3,
                'tipe' => 'dinamis', 
                'status' => 'aktif',
                'parent_id' => 0, 
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // ID 5: Event (URUTAN BERUBAH)
            [
                'id' => 5, 
                'nama' => 'Event',
                'urutan' => 4,
                'tipe' => 'dinamis', 
                'status' => 'aktif',
                'parent_id' => 0, 
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('tb_menu')->insert($parent_menus);

        // Menu ANAK (Child)
        // Parent ID 1 (Tentang Kami) kini menunjuk ke ID 2 yang baru.
        // Child menu 'Program Kerja' dihapus karena Parent ID 2 ('PROGRAM') telah dihapus.
        // ===========================================
        $child_menus = [
            // Anak Tentang Kami (Parent ID 2 - Tentang Kami)
            [
                'id' => 6, 
                'nama' => 'Sejarah',
                'urutan' => 1,
                'tipe' => 'statis',
                'status' => 'aktif',
                'parent_id' => 2, // Menunjuk ke 'Tentang Kami' (ID 2 yang baru)
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7, 
                'nama' => 'Organisasi',
                'urutan' => 2,
                'tipe' => 'dinamis',
                'status' => 'aktif',
                'parent_id' => 2, // Menunjuk ke 'Tentang Kami' (ID 2 yang baru)
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Menu Program Kerja (ID 8) telah dihapus dari sini.
        ];

        DB::table('tb_menu')->insert($child_menus);
    }
}
