<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambahkan kolom 'jenis_konten' ke tabel 'tb_menu'
        // Kolom ini ditempatkan setelah kolom 'urutan'
        Schema::table('tb_menu', function (Blueprint $table) {
            $table->string('jenis_konten', 50)->after('urutan'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom 'jenis_konten' jika rollback (undo migrasi)
        Schema::table('tb_menu', function (Blueprint $table) {
            $table->dropColumn('jenis_konten');
        });
    }
};