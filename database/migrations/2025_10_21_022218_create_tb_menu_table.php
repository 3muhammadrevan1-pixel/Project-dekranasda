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
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->id(); // id : int(11) AUTO_INCREMENT
            $table->string('nama', 100); // nama menu
            $table->integer('parent_id')->default(0); // parent_id : 0 artinya menu utama
            $table->integer('urutan'); // wajib diisi, tidak nullable

            // tipe menu
            $table->enum('tipe', ['statis', 'dinamis'])->default('statis');

            // status aktif / nonaktif
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            // created_at, updated_at - HARUS ADA SATU KALI SAJA
            $table->timestamps(); 

            // 👇 Tambahkan unique index untuk mencegah urutan ganda dalam parent yang sama
            $table->unique(['parent_id', 'urutan'], 'unique_parent_urutan');
            // BARIS $table->timestamps(); YANG DUPLIKAT DI SINI SUDAH DIHAPUS
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_menu');
    }
};
