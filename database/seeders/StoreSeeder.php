<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;



class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'name' => 'Bogor Square',
            'alamat' => 'Jl. Pajajaran No. 10, Bogor',
            'telepon' => '6289602397994',
        ]);

        Store::create([
            'name' => 'Sengked Store',
            'alamat' => 'Jl. Suryakencana No. 5, Bogor',
            'telepon' => '6285715727324',
        ]);
    }
}
