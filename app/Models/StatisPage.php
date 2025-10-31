<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatisPage extends Model
{
    use HasFactory;

    protected $table = 'statis_pages';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
    ];

    protected $casts = [
        'konten' => 'array', // otomatis decode JSON
    ];
}
