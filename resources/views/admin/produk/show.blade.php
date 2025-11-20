@extends('admin.layouts.app')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')

@php
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<div class="content">
    <h2 class="page-title text-2xl font-bold mb-6">Detail Produk</h2>

    {{-- Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif

    {{-- CARD 1: DETAIL PRODUK UTAMA --}}
    <div class="detail-card bg-white p-6 shadow-xl rounded-xl mb-8 flex flex-col md:flex-row gap-6">
        
        {{-- DETAIL KIRI: GAMBAR --}}
        <div class="detail-left md:w-1/3 flex-shrink-0">
            @if ($product->img)
                <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg shadow-md border-2 border-gray-100">
            @else
                <div class="placeholder-img w-full h-48 bg-gray-100 flex items-center justify-center text-gray-500 rounded-lg">
                    Gambar Utama Belum Tersedia
                </div>
            @endif
        </div>

        {{-- DETAIL KANAN: INFORMASI --}}
        <div class="detail-right md:w-2/3">
            <h3 class="detail-title text-xl font-bold mb-4 border-b pb-2 text-gray-800">{{ $product->name }}</h3>
            
            <div class="detail-grid grid grid-cols-2 gap-x-6 gap-y-3 text-gray-700 text-sm">
                
                <p class="col-span-2"><strong class="font-semibold text-gray-900">Harga Dasar:</strong> <span class="text-red-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span></p>
               
                <p><strong class="font-semibold text-gray-900">Kategori:</strong> {{ $product->category }}</p>
                <p><strong class="font-semibold text-gray-900">Type:</strong> {{ $product->type }}</p>

                <p><strong class="font-semibold text-gray-900">Nama Toko:</strong> {{ $product->store->name ?? 'N/A' }}</p>
                <p><strong class="font-semibold text-gray-900">Nomor Toko:</strong> {{ $product->store->telepon ?? 'N/A' }}</p>
                <p class="col-span-2"><strong class="font-semibold text-gray-900">Alamat Toko:</strong> {{ $product->store->alamat ?? 'N/A' }}</p>
            </div>

            <div class="detail-actions mt-6 space-x-3 border-t pt-4">
                {{-- TOMBOL EDIT PRODUK UTAMA --}}
                <a href="{{ route($rolePrefix . '.produk.edit', $product) }}" 
                    class="btn btn-edit bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition duration-150">
                    <i class="fas fa-edit"></i> Edit Produk
                </a>
                
                {{-- TOMBOL KEMBALI --}}
                <a href="{{ route($rolePrefix . '.produk.index') }}" 
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- CARD 2: MANAJEMEN VARIAN PRODUK (Hanya jika tipe bukan tunggal) --}}
    @if($product->type !== 'tunggal')
    <div class="detail-card bg-white p-6 shadow-xl rounded-xl">
        <h3 class="detail-title text-xl font-bold mb-4 border-b pb-2 text-gray-800">Manajemen Varian Produk ({{ $product->variants->count() }} Varian)</h3>
        
        {{-- TOMBOL TAMBAH VARIAN BARU --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route($rolePrefix . '.produk.createVariant', $product) }}"
                class="btn btn-edit bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition duration-150">
                <i class="fas fa-plus-circle"></i> Tambah Varian Baru
            </a>
        </div>

        {{-- Tabel Daftar Varian --}}
        <h4 class="text-xl font-bold mt-6 mb-3 text-gray-700">Daftar Varian Tersimpan</h4>
        <div class="table-wrapper overflow-x-auto shadow-md rounded-lg border">
            <table class="table min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Warna</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-32">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ukuran</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($product->variants as $variant)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($variant->img)
                                    <img src="{{ asset('storage/' . $variant->img) }}" alt="Varian" class="table-img w-12 h-12 object-cover rounded shadow-sm border">
                                @else
                                    <span class="text-xs text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $variant->color ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                + Rp {{ number_format($variant->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if ($variant->sizes)
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm">
                                        {{ implode(', ', (array)$variant->sizes) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                {{-- TOMBOL EDIT VARIAN --}}
                                <a href="{{ route($rolePrefix . '.produk.editVariant', $variant) }}"
                                  class="btn btn-edit bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition duration-150">
                                        <i class="fas fa-edit"></i>
                                </a>

                                {{-- TOMBOL HAPUS --}}
                                <form action="{{ route($rolePrefix . '.produk.destroyVariant', $variant) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus varian {{ $variant->color }} ini? Tindakan tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-sm bg-red-600 hover:bg-red-700 text-white">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                                Produk ini belum memiliki varian. Klik "Tambah Varian Baru" untuk membuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@endsection

@section('scripts')
{{-- Script tambahan jika diperlukan --}}
@endsection
