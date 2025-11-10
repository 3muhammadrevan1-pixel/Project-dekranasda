@extends('admin.layouts.app')

@section('title', 'Edit Varian: ' . ($variant->color ?? 'N/A'))

@section('content')

@php
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<div class="content">
    <div class="header-actions mb-6">
        <h2 class="text-2xl font-bold">Edit Varian Produk</h2>
    </div>

    {{-- Info Produk --}}
    <div class="bg-white p-6 shadow rounded-xl mb-6">
        <h4 class="text-lg font-bold text-gray-800 mb-1">Produk Induk: {{ $variant->product->name }}</h4>
        <p class="text-sm text-gray-500">Varian yang diedit: <strong class="text-indigo-600">{{ $variant->color ?? 'N/A' }}</strong></p>
    </div>

    {{-- Form Edit Varian --}}
    <div class="form-card bg-white p-6 shadow rounded-xl">
        <form action="{{ route($rolePrefix . '.produk.updateVariant', $variant) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Warna/Nama Varian --}}
                <div class="form-group">
                    <label for="color" class="block font-medium text-gray-700 mb-1">Warna/Nama Varian <span class="text-red-500">*</span></label>
                    <input type="text" name="color" id="color" 
                        value="{{ old('color', $variant->color) }}" 
                        class="form-control border rounded-lg w-full p-2 @error('color') is-invalid @enderror" 
                        placeholder="Contoh: Merah" required>
                    @error('color') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>
                
                {{-- Harga Tambahan --}}
                <div class="form-group">
                    <label for="variant_price" class="block font-medium text-gray-700 mb-1">Harga Tambahan (Rp)</label>
                    <input type="number" name="price" id="variant_price" 
                        value="{{ old('price', $variant->price) }}" step="0" 
                        class="form-control border rounded-lg w-full p-2 @error('price') is-invalid @enderror" 
                        placeholder="0">
                    @error('price') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                {{-- Ukuran/Atribut hanya untuk tipe warna_angka atau warna_huruf --}}
                @if(in_array($variant->product->type, ['warna_angka', 'warna_huruf']))
                <div class="form-group">
                    <label for="sizes" class="block font-medium text-gray-700 mb-1">
                        @if($variant->product->type === 'warna_angka') Ukuran Angka @else Ukuran Huruf @endif
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="sizes" id="sizes" 
                        value="{{ old('sizes', implode(', ', (array)$variant->sizes)) }}" 
                        class="form-control border rounded-lg w-full p-2 @error('sizes') is-invalid @enderror" 
                        placeholder="@if($variant->product->type === 'warna_angka') 38, 39, 40 @else S, M, L, XL @endif" required>
                    <small class="text-gray-500 text-xs mt-1 block">Pisahkan dengan koma (S, M, L atau 38, 39, 40).</small>
                    @error('sizes') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>
                @endif
                
                {{-- Gambar Varian --}}
                <div class="form-group">
                    <label for="img_variant">Gambar Varian (kosongkan jika tidak diubah)</label>
                    <div class="mb-2">
                        @if ($variant->img)
                            <img 
                                src="{{ asset('storage/' . $variant->img) }}" 
                                alt="Gambar Varian Saat Ini" 
                                class="preview-img" 
                                style="max-width: 150px; border-radius: 8px;"
                            >
                        @else
                            <p class="text-gray-500 text-sm">Belum ada gambar.</p>
                        @endif
                    </div>
                    <input 
                        type="file" 
                        id="img_variant" 
                        name="img" 
                        class="form-control file-input @error('img') is-invalid @enderror"
                    >
                    @error('img') 
                        <span class="error-message">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            
            {{-- Tombol Aksi --}}
            <div class="form-buttons mt-6 flex gap-3 border-t pt-4">
                <button type="submit" 
                        class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> Update Varian
                </button>

                <a href="{{ route($rolePrefix . '.produk.show', $variant->product) }}" 
                   class="btn btn-secondary bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Detail Produk
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
