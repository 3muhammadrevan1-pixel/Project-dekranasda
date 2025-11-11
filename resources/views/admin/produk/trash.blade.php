@extends('admin.layouts.app')

@section('title', 'Sampah Produk')

@section('content')
@php
    // Otomatis tentukan prefix route berdasarkan role
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<div class="content">
    <div class="header-actions">
        <h2 style="color: #e3921f;">Produk Baru Saja di Hapus</h2>
        
        {{-- Tombol kembali ke daftar produk aktif --}}
        <a href="{{ route($rolePrefix . '.produk.index') }}" class="btn" 
           style="background-color: #6c757d; color: white; border-radius: 5px; padding: 10px 15px; margin-left: 10px;">
            <i class=""></i> Kembali 
        </a>
    </div>

    {{-- Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 10%;">Gambar</th>
                    <th style="width: 30%;">Nama Produk</th>
                    <th style="width: 20%;">Toko</th>
                    <th style="width: 15%;">Dihapus Pada</th>
                    <th style="width: 20%; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td class="text-center">{{ $product->id }}</td>
                    <td>
                        @if ($product->img)
                            {{-- Menggunakan class table-img dari index view --}}
                            <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" class="table-img" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store->name ?? 'Toko Tidak Ditemukan' }}</td>
                    {{-- Waktu penghapusan ditampilkan dengan penekanan warna merah --}}
                    <td style="font-weight: 500; color: #e3921f;">
                        {{ $product->deleted_at ? $product->deleted_at->format('d M Y H:i') : 'N/A' }}
                    </td>
                    
                    <td class="actions">
                        
                        {{-- 1. Form Pulihkan (Restore) - Warna Hijau --}}
                        <form action="{{ route($rolePrefix . '.produk.restore', $product->id) }}" method="POST" class="inline-form">
                            @csrf
                            <button type="submit" class="btn btn-restore" title="Pulihkan Produk">
                                <i class="fas fa-undo"></i> Pulihkan
                            </button>
                        </form>
                        
                        {{-- 2. Form Hapus Permanen (Force Delete) - Warna Merah Gelap --}}
                        <form action="{{ route($rolePrefix . '.produk.forceDelete', $product->id) }}" method="POST" class="inline-form" onsubmit="return confirm('PERINGATAN! Anda yakin ingin MENGHAPUS PERMANEN produk {{ $product->name }}? Tindakan ini tidak bisa dibatalkan dan datanya akan hilang selamanya.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-force-delete" title="Hapus Permanen">
                                <i class="fas fa-eraser"></i> Permanen
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-500">
                        Sampah kosong. Tidak ada produk yang dihapus sementara.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination (jika ada) --}}
    @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->total() > 0)
        <div class="pagination-container" style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; flex-wrap: wrap;">
            <div class="pagination-info" style="font-size: 0.9rem; color: #6b7280; padding: 0.5rem 0;">
                Menampilkan 
                <span style="font-weight: 600;">{{ $products->firstItem() }}</span>
                sampai
                <span style="font-weight: 600;">{{ $products->lastItem() }}</span>
                dari total 
                <span style="font-weight: 600;">{{ $products->total() }}</span> produk di sampah.
            </div>
            <div class="pagination-links-wrapper">
                {{ $products->onEachSide(1)->links('page.pagenation') }}
            </div>
        </div>
    @endif
    
    {{-- Inline CSS untuk memastikan tampilan tombol aksi terlihat bagus --}}
    <style>
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .actions .btn {
            font-size: 0.8rem; /* Sedikit lebih kecil agar muat */
            padding: 6px 10px;
            margin: 0 2px;
            display: inline-flex;
            align-items: center;
        }
        .actions .btn i {
            margin-right: 4px;
        }
        .btn-restore {
            background-color: #28a745; /* Hijau */
            color: white;
            border: 1px solid #28a745;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .btn-restore:hover {
            background-color: #218838;
        }
        .btn-force-delete {
            background-color: #c82333; /* Merah Gelap */
            color: white;
            border: 1px solid #c82333;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .btn-force-delete:hover {
            background-color: #a71d2a;
        }
        .table-img {
            border: 1px solid #eee;
        }
    </style>
</div>
@endsection