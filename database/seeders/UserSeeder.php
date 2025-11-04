<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // WAJIB: Import ini untuk menggunakan Hash::make()

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ⭐ PERBAIKAN: Selalu gunakan Hash::make() di Seeder untuk memastikan keamanan data.
        User::create([
            'name' => 'admin', 
            'email' => 'admin@dekranasda.go.id', 
            'status' => 'aktif', 
            'role' => 'admin', 
            'password' => Hash::make('admin.225#') // Pastikan di-hash di sini
        ]);

        User::create([
            'name' => 'operator', 
            'email' => 'operator@dekranasda.go.id', 
            'status' => 'aktif', 
            'role' => 'operator', 
            'password' => Hash::make('operator.225#') // Pastikan di-hash di sini
        ]);
    }
}
