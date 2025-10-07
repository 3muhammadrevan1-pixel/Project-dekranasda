<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory;

     protected $fillable = [
        'store_id',
        'name',
        'desc',
        'img',
        'category',
        'type',
        'price',
    ];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
}
