<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'store_id',
        'name',
        'desc',
        'img',
        'category',
        'type',
        'price',
    ];

     // WAJIB: Tambahkan 'deleted_at' ke $dates agar di-casting menjadi Carbon instance
    protected $dates = ['deleted_at'];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
}
