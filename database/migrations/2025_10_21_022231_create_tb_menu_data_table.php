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
        Schema::create('tb_menu_data', function (Blueprint $table) {
           $table->id();
            
            // Foreign Key ke tb_menu
            $table->foreignId('menu_id')
                  ->constrained('tb_menu') // WAJIB ada, relasi ke tabel yang baru kita buat
                  ->onDelete('cascade'); // Jika menu induk dihapus, datanya ikut terhapus
            
            $table->string('jenis_konten', 50)->comment('Kunci Pembeda: news, event, program, gallery');
            $table->string('title', 255);
            $table->longText('content')->nullable();
            $table->string('img', 255)->nullable(); // Link Gambar
            $table->date('date')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_menu_data');
    }
};
