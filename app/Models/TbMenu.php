<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class TbMenu extends Model
{
    use HasFactory;

    // Definisikan nama tabel yang spesifik
    protected $table = 'tb_menu';
    
    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'nama', 
        'parent_id', 
        'urutan', 
        'jenis_konten', // <-- DIGANTI: Menggantikan 'tipe'
        'status',
    ];
    
    
    protected $casts = [
        'parent_id' => 'integer',
        'urutan' => 'integer',
        // HAPUS cast untuk 'tipe'
    ];

    /**
     * Scope: hanya ambil menu yang aktif.
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope: urutkan menu berdasarkan kolom 'urutan'.
     */
    public function scopeUrut(Builder $query): Builder
    {
        return $query->orderBy('urutan', 'asc');
    } 

    /**
     * Relasi ke konten (One to Many).
     * Fungsi ini dipertahankan untuk kompatibilitas.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(TbMenuData::class, 'menu_id');
    }

   /**
     * Relasi self (Parent).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('urutan', 'asc');
    }

    /**
     * Optional: Ambil children secara rekursif (nested menu).
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }
    
    /**
     * Relasi untuk mendapatkan SEMUA konten (berita, event, galeri, dll) 
     * yang terkait dengan menu ini dari tabel tb_menu_data.
     */
    public function dataKonten(): HasMany
    {
        // Menghubungkan TbMenu ke TbMenuData melalui menu_id
        return $this->hasMany(TbMenuData::class, 'menu_id', 'id');
    }
}