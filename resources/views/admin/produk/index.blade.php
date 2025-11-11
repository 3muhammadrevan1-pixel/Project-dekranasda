@extends('admin.layouts.app')

@section('title', 'Daftar Produk')

@section('content')
@php
    // Otomatis tentukan prefix route berdasarkan role
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<div class="content">
    <div class="header-actions" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Daftar Produk</h2>
        
        {{-- TOMBOL BARU: Link ke halaman Sampah --}}
        {{-- Menggunakan inline style sederhana untuk membedakannya jika custom CSS 'btn-trash' tidak tersedia --}}
        <a href="{{ route($rolePrefix . '.produk.trash') }}" class="btn" 
           style="background-color: #f0ad4e; color: white; border-radius: 5px; padding: 10px 15px; margin-left: auto; margin-right: 10px;">
            <i class="fas fa-trash-restore"></i> Sampah ({{ \App\Models\Product::onlyTrashed()->count() }})
        </a>

        {{-- Tombol Tambah Produk --}}
        <a href="{{ route($rolePrefix . '.produk.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="alert alert-error mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Toko</th>
                    <th>Kategori</th>
                    <th>Type</th>
                    <th>Harga</th>
                    <th style="width:140px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="text-center">{{ $product->id }}</td>
                        <td>
                            @if ($product->img)
                                <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" class="table-img">
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->store->name ?? 'Toko Tidak Ditemukan' }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->type }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="actions">
                            {{-- Button Detail --}}
                            <a href="{{ route($rolePrefix . '.produk.show', $product) }}" class="btn btn-view">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- Button Edit --}}
                            <a href="{{ route($rolePrefix . '.produk.edit', $product) }}" class="btn btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Form Hapus (Pindah ke Sampah / Soft Delete) --}}
                            <form action="{{ route($rolePrefix . '.produk.destroy', $product) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin memindahkan produk {{ $product->name }} ke Sampah?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" title="Pindah ke Sampah">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center p-4 text-gray-500">
                            Tidak ada data produk yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->total() > 0)
        <div class="pagination-container" style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; flex-wrap: wrap;">
            <div class="pagination-info" style="font-size: 0.9rem; color: #6b7280; padding: 0.5rem 0;">
                Menampilkan 
                <span style="font-weight: 600;">{{ $products->firstItem() }}</span>
                sampai
                <span style="font-weight: 600;">{{ $products->lastItem() }}</span>
                dari total 
                <span style="font-weight: 600;">{{ $products->total() }}</span> produk.
            </div>
            <div class="pagination-links-wrapper">
                {{ $products->onEachSide(1)->links('page.pagenation') }}
            </div>
        </div>
    @endif
</div>
@endsection