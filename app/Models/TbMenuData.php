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

    // WAJIB: Definisikan daftar jenis konten BARU yang akan digunakan oleh TbMenu
    const JENIS_KONTEN = [
        'statis'            => 'Halaman Statis',                    // Konten tunggal (misal: Tentang Kami, Kontak)
        'dinamis'           => 'Konten Dinamis (Detail / Link)',    // GABUNGAN: Tampilan ditentukan oleh kolom 'link'
        'media'             => 'Media Foto',                        // Hanya menginput Foto
        'organisasi'        => 'Struktur',                          // Konten khusus (Struktur)
    ];

    protected $fillable = [
        'menu_id',
        'jenis_konten', // <-- Nilai ini akan diisi otomatis dari TbMenu
        'title',
        'content', 
        'img',
        'date',
        'location',
        'link',         // Kolom ini yang akan menentukan tampilan dinamis
        // Catatan: Data organisasi ('jabatan', 'deskripsi_organisasi') 
        // harus disimpan sebagai JSON di kolom 'content'.
    ];

    protected $casts = [
        'date' => 'date',
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
            
            // Cek apakah hasil decode adalah array/objek yang valid dan tidak kosong
            if (is_array($data) && json_last_error() === JSON_ERROR_NONE && !empty($data)) {
                // Asumsi data organisasi disimpan sebagai array di kolom 'content', 
                // kita ambil elemen pertama jika ada.
                return $data[0] ?? ['jabatan' => null, 'deskripsi' => null];
            }
        }
        
        // Return array default yang aman:
        // - 'jabatan' selalu null kecuali jika organisasi
        // - 'deskripsi' mengambil nilai langsung dari 'content' untuk non-organisasi
        return ['jabatan' => null, 'deskripsi' => $this->content]; 
    }
}