<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organisasi;


class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Organisasi::create([
            'nama' => 'Dedie Abdul Rachim',
            'jabatan' => 'Pembina',
            'img' => 'organisasi/Dedie_Abdu_Rachim,_Wali_Kota_Bogor_(2025).png',
            'deskripsi' => 'Sebagai Wali Kota Bogor sekaligus Pembina, memberikan arahan strategis.'
        ]);

        Organisasi::create([
            'nama' => 'Yantie Rachim',
            'jabatan' => 'Ketua Umum',
            'img' => 'organisasi/ketua.png',
            'deskripsi' => 'Bertanggung jawab sebagai pimpinan utama Dekranasda.'
        ]);

        Organisasi::create([
            'nama' => 'Rahmat Hidayat',
            'jabatan' => 'Ketua Harian',
            'img' => 'organisasi/ketua2.png',
            'deskripsi' => 'Mendukung Ketua Umum dalam pelaksanaan program kerja sehari-hari.'
        ]);
    }
}
