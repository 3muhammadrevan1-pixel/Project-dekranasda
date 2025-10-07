<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::create([
            'title' => 'Pengurus Dekranasda Kota Bogor 2025–2030 Resmi Dilantik, Fokus pada Digitalisasi dan Pengembangan UMKM',
            'img' => 'berita/brt1.png',
            'date' => '2025-08-20',
            'content' => 'Wakil Wali Kota Bogor, Jenal Mutaqin, menekankan bahwa ...',
            'location' => 'Bogor',
         
        ]);

        News::create([
            'title' => 'Pererat Silaturahmi, Yantie Rachim Sambut Rombongan GOW dan TP PKK Tangerang Selatan',
            'img' => 'berita/brt2.jpg',
            'date' => '2025-08-25',
            'content' => 'Dekranasda Kota Bogor menerima kunjungan rombongan GOW ...',
            'location' => 'Bogor Timur',
            
        ]);

        News::create([
            'title' => 'Dekranasda Kota Bogor Bidik Batik Bogor Bisa Mendunia',
            'img' => 'berita/brt3.jpg',
            'date' => '2025-04-27',
            'content' => 'Ketua Dekranasda Kota Bogor Yantie Rachim menyampaikan mimpinya ...',
            'location' => 'Bogor',
            
        ]);
    }
}
