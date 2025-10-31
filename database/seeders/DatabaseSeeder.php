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
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

         $this->call([
            MenuSeeder::class, 
            
            // Seeder yang bergantung pada MenuSeeder
            GallerySeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            OrganisasiSeeder::class,
        
            
            // Seeder lain yang bersifat independen
            ProductSeeder::class,
            StoreSeeder::class,
            StatisPageSeeder::class,
            
        ]);
    }
}
