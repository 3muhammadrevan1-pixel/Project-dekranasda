<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            'storage/galeri/g1.jpg',
            'storage/galeri/g2.webp',
            'storage/galeri/g3.jpg',
            'storage/galeri/g4.jpg',
            'storage/galeri/g5.jpeg',
            'storage/galeri/g6.jpeg',
            'storage/galeri/g7.webp',
            'storage/galeri/g8.jpg',
            'storage/galeri/g9.webp',
        ];

        foreach ($images as $img) {
            Gallery::create([
                'img' => $img,
            ]);
        }
    }
}
