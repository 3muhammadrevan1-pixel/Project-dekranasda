<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;

   protected $fillable = [
        'title',
        'img',
        'date',
        'content',
        'location',
       
    ];
}
