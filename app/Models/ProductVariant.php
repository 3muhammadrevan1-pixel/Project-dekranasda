<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductSize;


class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color', 'img', 'price', 'sizes'];
    protected $casts = [
        'sizes' => 'array', 
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function sizes()
    // {
    //     return $this->hasMany(ProductSize::class, 'variant_id');
    // }
}
