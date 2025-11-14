@extends('admin.layouts.app')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')
@php
    // Tentukan prefix route berdasarkan role user
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<div class="content">

    <div class="header-actions mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold">Edit Produk: {{ $product->name }}</h2>
        <a href="{{ route($rolePrefix . '.produk.show', $product) }}" class="btn btn-secondary">
            <i class="fas fa-eye"></i> Lihat Detail
        </a>
    </div>

    {{-- Notifikasi Error / Success --}}
    @if (session('error'))
        <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="form-card bg-white p-6 shadow-lg rounded-lg">
        <form action="{{ route($rolePrefix . '.produk.update', $product) }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT')

            {{-- Nama Produk --}}
            <div class="form-group mb-4">
                <label for="name" class="block font-medium text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    value="{{ old('name', $product->name) }}" 
                    required 
                    class="form-control w-full border rounded p-2 @error('name') border-red-500 @enderror"
                    placeholder="Masukkan nama produk"
                >
                @error('name') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Toko --}}
            <div class="form-group mb-4">
                <label for="store_id" class="block font-medium text-gray-700">Toko <span class="text-red-500">*</span></label>
                <select 
                    id="store_id" 
                    name="store_id" 
                    required 
                    class="form-control w-full border rounded p-2 @error('store_id') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Toko --</option>
                    @foreach ($stores as $store)
                        <option 
                            value="{{ $store->id }}" 
                            {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}
                        >
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
                @error('store_id') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="form-group mb-4">
                <label for="category" class="block font-medium text-gray-700">Kategori</label>
                <select 
                    id="category" 
                    name="category"
                    class="form-control w-full border rounded p-2 @error('category') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Kategori --</option>
                    @php $selectedCategory = old('category', $product->category); @endphp
                    <option value="Fashion" {{ $selectedCategory == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                    <option value="Kerajinan" {{ $selectedCategory == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                </select>
                @error('category') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="form-group mb-4">
                <label for="desc" class="block font-medium text-gray-700">Deskripsi</label>
                <textarea 
                    id="desc" 
                    name="desc" 
                    rows="4" 
                    class="form-control w-full border rounded p-2 @error('desc') border-red-500 @enderror" 
                    placeholder="Masukkan deskripsi produk"
                >{{ old('desc', $product->desc) }}</textarea>
                @error('desc') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Harga --}}
            <div class="form-group mb-4">
                <label for="price" class="block font-medium text-gray-700">Harga <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    step="0.01" 
                    value="{{ old('price', $product->price) }}" 
                    required
                    class="form-control w-full border rounded p-2 @error('price') border-red-500 @enderror" 
                    placeholder="Masukkan harga produk"
                >
                @error('price') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Gambar Produk --}}
            <div class="form-group mb-6">
                <label for="img" class="block font-medium text-gray-700">Gambar Produk (kosongkan jika tidak diubah)</label>
                <div class="mb-2">
                    @if ($product->img)
                        <img 
                            src="{{ asset('storage/' . $product->img) }}" 
                            alt="Gambar Saat Ini" 
                            class="preview-img" 
                            style="max-width: 150px; border-radius: 8px; object-fit: cover;"
                        >
                    @else
                        <p class="text-gray-500 text-sm">Belum ada gambar.</p>
                    @endif
                </div>
                <input 
                    type="file" 
                    id="img" 
                    name="img" 
                    class="form-control file-input w-full border rounded p-2 @error('img') border-red-500 @enderror"
                >
                <small class="text-gray-500 text-sm">Ukuran maksimal 2MB </small>
                @error('img') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-actions flex gap-3">
                <button type="submit" class="btn btn-primary px-4 py-2">
                    <i class="fas fa-save"></i> Update Produk
                </button>
                <a href="{{ route($rolePrefix . '.produk.index') }}" class="btn btn-secondary px-4 py-2">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

{{-- Validasi Ukuran Gambar --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imgInput = document.getElementById('img');

    if (imgInput) {
        imgInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) { // Maksimum 2MB
                alert('Ukuran gambar melebihi 2MB! Silakan pilih gambar yang lebih kecil.');
                this.value = ''; // Reset input file
            }
        });
    }
});
</script>
@endsection
