<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Product::select('category')->distinct()->pluck('category');

        // ambil semua produk + relasi
       $allProducts = Product::with(['store', 'variants'])->get();

        // Mapping buat kebutuhan JS/frontend
        $allProductsJs = $allProducts->map(function ($product) {
            return [
                'id'    => $product->id,
                'name'  => $product->name,
                'type'  => $product->type,
                'img'   => $product->img ? asset('storage/' . $product->img) : null,
                'price' => $product->price,
                'desc'  => $product->desc,

                'store' => $product->store ? [
                    'name'   => $product->store->name,
                    'alamat' => $product->store->alamat,
                    'telepon' => $product->store->telepon ?? '-', // amanin telepon
                ] : null,

                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'color' => $variant->color,
                        'img'   => $variant->img ? asset('storage/' . $variant->img) : null,
                        'price' => $variant->price,
                        'sizes' => $variant->sizes ?? [],
                    ];
                })
            ];
        });

       return view('produk.index', compact('categories', 'allProducts', 'allProductsJs'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
