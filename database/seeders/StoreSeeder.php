<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store; // Pastikan model Store diimpor


class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan firstOrCreate agar toko tidak duplikat saat seeder dijalankan berkali-kali.
        Store::firstOrCreate(
            ['name' => 'Bogor Square'], // Kriteria pencarian
            [
                'alamat' => 'Jl. Pajajaran No. 10, Bogor',
                'telepon' => '6289602397994',
            ] // Data untuk membuat jika toko tidak ditemukan
        );

        Store::firstOrCreate(
            ['name' => 'Sengked Store'],
            [
                'alamat' => 'Jl. Suryakencana No. 5, Bogor',
                'telepon' => '6285715727324',
            ]
        );
    }
}
