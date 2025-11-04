<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Seeder yang bergantung pada MenuSeeder
            TbMenuSeeder::class, 
            GallerySeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            OrganisasiSeeder::class,
        
            // Seeder lain yang bersifat independen
            StoreSeeder::class,
            ProductSeeder::class,
            StatisPageSeeder::class,

            // Ini yang berisi 2 akun spesifik Anda
            UserSeeder::class,
            
        ]);
    }
}
