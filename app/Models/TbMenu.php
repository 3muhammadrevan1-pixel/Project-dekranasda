<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TbMenu extends Model
{
    use HasFactory;

    // Definisikan nama tabel yang spesifik
    protected $table = 'tb_menu';
    
    // Matikan Laravel default primary key incrementing jika id bukan int (tapi di sini int, jadi opsional)
    // public $incrementing = true; 

    // Daftar kolom yang boleh diisi (sesuai skema migration Anda)
    protected $fillable = [
        'nama', 
        'parent_id', 
        'urutan', 
        'tipe', 
        'status',
    ];
    
    
    protected $casts = [
        'parent_id' => 'integer',
        'urutan' => 'integer',
    ];

    /**
     * Scope: hanya ambil menu yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope: urutkan menu berdasarkan kolom 'urutan'.
     */
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan', 'asc');
    } 

    /**
     * Relasi ke konten (One to Many)
     */
    public function contents()
    {
        return $this->hasMany(TbMenuData::class, 'menu_id');
    }

 /**
     * Relasi self (Parent)
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('urutan', 'asc');
    }

    /**
     * Optional: Ambil children secara rekursif (nested menu)
     */
    public function allChildren()
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
