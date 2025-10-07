<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'img',
        'desc',
        'date',
        'lokasi',
        'link',
    ];
}
