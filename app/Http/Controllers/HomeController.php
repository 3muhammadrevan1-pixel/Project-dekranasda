<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Product;
use App\Models\Program;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $allProducts = Product::with(['store', 'variants.sizes'])->get();

        $allProductsJs = $allProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'img' => $product->img ? asset('storage/' . $product->img) : null,
                'price' => $product->price,
                'desc' => $product->desc,
                'store' => $product->store ? [
                    'name' => $product->store->name,
                    'alamat' => $product->store->alamat,
                    'telepon' => $product->store->telepon ?? '-',
                ] : null,
                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'color' => $variant->color,
                        'img' => $variant->img ? asset('storage/' . $variant->img) : null,
                        'price' => $variant->price,
                        'sizes' => $variant->sizes->pluck('size'),
                    ];
                })
            ];
        });

        $galeri = Gallery::take(6)->get();
        $news = News::latest()->take(6)->get();

        $programKerja = Program::all()
            ->groupBy('bidang')
            ->map(fn($items, $bidang) => [
                'bidang' => $bidang,
                'program' => $items->map(fn($item) => [
                    'judul' => $item->judul,
                    'deskripsi' => $item->deskripsi
                ])
            ])->values();

        return view('home', compact('programKerja', 'news', 'galeri', 'allProducts', 'allProductsJs'))
            ->with('title', 'Beranda - Dekranasda Kota Bogor');
    }
}
