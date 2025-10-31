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
        'status'
    ];
    
    public function parent(): BelongsTo
    {
        // Menu mencari parent-nya di tabel yang sama
        return $this->belongsTo(TbMenu::class, 'parent_id', 'id');
    }

    /**
     * Relasi untuk mendapatkan semua sub-menu (Children) dari menu saat ini.
     */
    public function children(): HasMany
    {
        // Menu lain menunjuk ke ID ini sebagai parent_id
        return $this->hasMany(TbMenu::class, 'parent_id', 'id')->orderBy('urutan');
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
