@extends('admin.layouts.app')

@section('title', 'Tambah Varian Produk: ' . $product->name)

@section('content')

@php
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<div class="content">

    {{-- Info Produk Induk --}}
    <div class="detail-card bg-white p-6 shadow-xl rounded-xl mb-8 flex flex-col md:flex-row gap-6">
        {{-- Gambar --}}
        <div class="detail-left md:w-1/3 flex-shrink-0">
            @if ($product->img)
                <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg shadow-md border-2 border-gray-100">
            @else
                <div class="placeholder-img w-full h-48 bg-gray-100 flex items-center justify-center text-gray-500 rounded-lg">
                    Gambar Utama Belum Tersedia
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="detail-right md:w-2/3">
            <h3 class="detail-title text-xl font-bold mb-4 border-b pb-2 text-gray-800">{{ $product->name }}</h3>
            
            <div class="detail-grid grid grid-cols-2 gap-x-6 gap-y-3 text-gray-700 text-sm">
                <p class="col-span-2"><strong class="font-semibold text-gray-900">Harga Dasar:</strong> <span class="text-red-600 font-bold">Rp {{ number_format($product->price,0,',','.') }}</span></p>
                <p class="col-span-2"><strong class="font-semibold text-gray-900">Deskripsi:</strong> {{ $product->desc }}</p>
                <p><strong class="font-semibold text-gray-900">Kategori:</strong> {{ $product->category }}</p>
                <p><strong class="font-semibold text-gray-900">Tipe:</strong> {{ $product->type }}</p>
            </div>
        </div>
    </div>

    {{-- Notifikasi Error --}}
    @if (session('error'))
        <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif

    <div class="form-card">
        {{-- Form Tambah Varian --}}
        <form action="{{ route($rolePrefix . '.produk.storeVariant', $product) }}" method="POST" enctype="multipart/form-data" class="form" id="variant-form">
            @csrf

            {{-- Warna/Nama Varian --}}
            <div class="form-group">
                <label for="color">Warna<span class="required"></span></label>
                <input 
                    type="text" 
                    id="color" 
                    name="color" 
                    value="{{ old('color') }}" 
                    required 
                    class="form-control @error('color') is-invalid @enderror" 
                    placeholder="Contoh: Merah, Hitam"
                >
                @error('color')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            {{-- Harga Tambahan --}}
            <div class="form-group">
                <label for="price">Harga <span class="required"></span></label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    step="0.01" 
                    value="{{ old('price', 0) }}" 
                    required
                    class="form-control @error('price') is-invalid @enderror" 
                    placeholder="Tambahan harga varian"
                >
                @error('price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            

            {{-- Ukuran --}}
            @if($product->type === 'warna_angka')
            <div class="form-group">
                <label for="sizes">Ukuran Angka <span class="required"></span></label>
                <input 
                    type="text" 
                    id="sizes" 
                    name="sizes" 
                    value="{{ old('sizes') }}" 
                    class="form-control @error('sizes') is-invalid @enderror" 
                    placeholder="Contoh: 38,39,40" 
                    required
                >
                @error('sizes')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            @elseif($product->type === 'warna_huruf')
            <div class="form-group">
                <label for="sizes">Ukuran Huruf <span class="required"></span></label>
                <input 
                    type="text" 
                    id="sizes" 
                    name="sizes" 
                    value="{{ old('sizes') }}" 
                    class="form-control @error('sizes') is-invalid @enderror" 
                    placeholder="Contoh: S,M,L,XL" 
                    required
                >
                @error('sizes')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            @endif
            {{-- Gambar Varian --}}
            <div class="form-group">
                <label for="img">Gambar Variant</label>
                <input 
                    type="file" 
                    id="img" 
                    name="img" 
                    class="form-control file-input @error('img') is-invalid @enderror"
                >
                @error('img')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-actions mt-6">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Varian
                </button>
                <a href="{{ route($rolePrefix . '.produk.show', $product) }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection

{{-- Script Dinamis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const variantForm = document.getElementById('variant-form');
    const priceInput = document.getElementById('price');
    const sizesInput = document.getElementById('sizes');

    // Validasi sebelum submit
    variantForm.addEventListener('submit', function(e) {
        let errors = [];
        const price = priceInput.value.trim();
        const sizes = sizesInput ? sizesInput.value.trim() : null;

        if (!price) errors.push('Harga tambahan wajib diisi!');

        if (sizesInput) {
            if (!sizes) errors.push('Ukuran wajib diisi!');
            if ({{ json_encode($product->type) }} === 'warna_angka' && /[^0-9,]/.test(sizes)) errors.push('Ukuran angka hanya boleh angka dan koma!');
            if ({{ json_encode($product->type) }} === 'warna_huruf' && /[^a-zA-Z\s,]/.test(sizes)) errors.push('Ukuran huruf hanya boleh huruf, spasi, dan koma!');
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
});
</script>
