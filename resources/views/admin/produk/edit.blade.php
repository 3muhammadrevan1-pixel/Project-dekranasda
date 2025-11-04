@extends('admin.layouts.app')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')

<div class="content">
    <div class="header-actions">
        <h2>Edit Produk: {{ $product->name }}</h2>
        <a href="{{ route('admin.produk.show', $product) }}" class="btn btn-secondary">
            <i class="fas fa-eye"></i> Lihat Detail
        </a>
    </div>

    {{-- Notifikasi Error/Success --}}
    @if(session('error'))
        <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="form-card">
        {{-- ACTION FORM disesuaikan ke ProductController@update dengan ID produk --}}
        <form action="{{ route('admin.produk.update', $product) }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT')
            
            {{-- Nama Produk --}}
            <div class="form-group">
                <label for="name">Nama Produk <span class="required">*</span></label>
                <input type="text" id="name" name="name" 
                       value="{{ old('name', $product->name) }}" 
                       required 
                       class="form-control @error('name') is-invalid @enderror">
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Toko (Dropdown Dinamis) --}}
            <div class="form-group">
                <label for="store_id">Toko <span class="required">*</span></label>
                <select id="store_id" name="store_id" required class="form-control @error('store_id') is-invalid @enderror">
                    <option value="">-- Pilih Toko --</option>
                    {{-- Loop data toko dari controller (compact('stores')) --}}
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}" 
                                {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
                @error('store_id') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Kategori --}}
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" id="category" name="category" 
                           value="{{ old('category', $product->category) }}" 
                           class="form-control @error('category') is-invalid @enderror">
                    @error('category') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                
                {{-- Tipe (Menggantikan 'opsional') --}}
                <div class="form-group">
                    <label for="type">Tipe Produk</label>
                    <input type="text" id="type" name="type" 
                           value="{{ old('type', $product->type) }}" 
                           class="form-control @error('type') is-invalid @enderror" 
                           placeholder="Contoh: Baju, Sepatu">
                    @error('type') <span class="error-message">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="desc">Deskripsi</label>
                <textarea id="desc" name="desc" rows="4" 
                          class="form-control @error('desc') is-invalid @enderror" 
                          placeholder="Masukkan deskripsi produk">{{ old('desc', $product->desc) }}</textarea>
                @error('desc') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Harga --}}
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" step="0.01" 
                       value="{{ old('price', $product->price) }}" 
                       class="form-control @error('price') is-invalid @enderror" 
                       placeholder="Masukkan harga produk">
                @error('price') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            
            {{-- Gambar Produk --}}
            <div class="form-group">
                <label for="img">Gambar Produk (Biarkan kosong jika tidak ingin diubah)</label>
                <div class="mb-2">
                    @if($product->img)
                        <img src="{{ asset('storage/' . $product->img) }}" alt="Gambar Saat Ini" class="preview-img" style="max-width: 150px; border-radius: 8px;">
                        <p class="text-xs mt-1 text-gray-500">Gambar saat ini.</p>
                    @else
                        <p class="text-xs text-gray-500">Belum ada gambar utama.</p>
                    @endif
                </div>
                <input type="file" id="img" name="img" class="form-control file-input @error('img') is-invalid @enderror">
                @error('img') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions mt-6">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sync"></i> Update Produk
                </button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
