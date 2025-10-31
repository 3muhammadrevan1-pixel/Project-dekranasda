<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class TbMenuData extends Model
{
    use HasFactory;

    protected $table = 'tb_menu_data';

    protected $fillable = [
        'menu_id',
        'jenis_konten',
        'title',
        'content', 
        'img',
        'date',
        'location',
        'link',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
    
    // Tambahkan accessor untuk data organisasi yang sudah didekode
    protected $appends = ['organisasi_data'];
    
    public function menu(): BelongsTo
    {
        return $this->belongsTo(TbMenu::class, 'menu_id');
    }

    public function scopeOfJenis(Builder $query, string $jenis): Builder
    {
        return $query->where('jenis_konten', $jenis);
    }
    
    /**
     * Aksesori untuk mendekode JSON di kolom 'content' 
     * HANYA jika jenis_konten adalah 'organisasi'.
     */
    public function getOrganisasiDataAttribute(): array
    {
        if ($this->jenis_konten === 'organisasi' && $this->content) {
            // Dekode JSON string dari kolom 'content'
            $data = json_decode($this->content, true); 
            
            // Jika berhasil didekode dan hasilnya adalah array/objek, ambil elemen pertama
            if (is_array($data) && json_last_error() === JSON_ERROR_NONE) {
                // Return elemen array pertama, atau array default jika kosong
                return $data[0] ?? ['jabatan' => null, 'deskripsi' => null];
            }
        }
        
        // Return array default yang aman jika bukan organisasi atau decode gagal
        return ['jabatan' => null, 'deskripsi' => $this->content]; 
    }
}
