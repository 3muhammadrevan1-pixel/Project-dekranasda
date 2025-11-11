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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade'); // tiap produk punya toko
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('img')->nullable();
            $table->string('category');
            $table->string('type')->nullable(); // baju, sepatu, none
            $table->integer('price')->nullable(); 
            $table->timestamps();
            
            // BARIS PENTING: Menambahkan kolom 'deleted_at' untuk Soft Deletes
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};