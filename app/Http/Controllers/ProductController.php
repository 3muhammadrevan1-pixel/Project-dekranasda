<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Tampilkan semua produk (frontend)
     */
    public function index()
    {
        // Ambil semua kategori unik dari tabel products
        $categories = Product::select('category')->distinct()->pluck('category');

        // Ambil semua produk beserta relasinya, default urut terbaru
        $allProducts = Product::with(['store', 'variants'])
            ->orderByDesc('created_at')
            ->get();

        // Produk unggulan = 10 produk dengan click_count tertinggi
        $topProducts = Product::with(['store', 'variants'])
            ->orderByDesc('click_count')
            ->take(10)
            ->get();

        // Produk terbaru = 10 produk terbaru
        $latestProducts = Product::with(['store', 'variants'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Mapping untuk kebutuhan frontend (JavaScript)
        $allProductsJs = $allProducts->map(function ($product) {
            return [
                'id'    => $product->id,
                'name'  => $product->name,
                'type'  => $product->type,
                'img'   => $product->img ? asset('storage/' . $product->img) : (optional($product->variants->first())->img ? asset('storage/' . $product->variants->first()->img) : null),
                'price' => $product->price ?? optional($product->variants->first())->price,
                'desc'  => $product->desc,
                'click_count' => $product->click_count,
                'category' => strtolower($product->category),
                'store' => $product->store ? [
                    'name'   => $product->store->name,
                    'alamat' => $product->store->alamat,
                    'telepon' => $product->store->telepon ?? '-',
                ] : null,
                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'color' => $variant->color,
                        'img'   => $variant->img ? asset('storage/' . $variant->img) : null,
                        'price' => $variant->price,
                        'sizes' => $variant->sizes ?? [],
                    ];
                }),
            ];
        });

        // Kirim semua data ke view
        return view('produk.index', compact(
            'categories',
            'allProducts',
            'topProducts',
            'latestProducts',
            'allProductsJs'
        ));
    }

    /**
     * Tambah 1 klik ke produk (dipanggil lewat AJAX dari frontend)
     */
    public function addClick($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->increment('click_count');
            return response()->json([
                'success' => true,
                'click_count' => $product->click_count
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan'
        ], 404);
    }

}
