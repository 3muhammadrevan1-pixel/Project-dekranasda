@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="content">
    
    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="alert alert-error mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-card">
        {{-- ACTION FORM disesuaikan ke ProductController@store --}}
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            
            {{-- Nama Produk --}}
            <div class="form-group">
                <label for="name">Nama Produk <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama produk">
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Toko (Dropdown Dinamis) --}}
            <div class="form-group">
                <label for="store_id">Toko <span class="required">*</span></label>
                <select id="store_id" name="store_id" required class="form-control @error('store_id') is-invalid @enderror">
                    <option value="">-- Pilih Toko --</option>
                    {{-- Loop data toko dari controller (compact('stores')) --}}
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
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
                    <input type="text" id="category" name="category" value="{{ old('category') }}" class="form-control @error('category') is-invalid @enderror" placeholder="Contoh: Fashion, Kerajinan">
                    @error('category') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                
                {{-- Tipe --}}
                <div class="form-group">
                    <label for="type">Tipe Produk</label>
                    <input type="text" id="type" name="type" value="{{ old('type') }}" class="form-control @error('type') is-invalid @enderror" placeholder="Contoh: Baju, Sepatu">
                    @error('type') <span class="error-message">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="desc">Deskripsi</label>
                <textarea id="desc" name="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" placeholder="Masukkan deskripsi produk">{{ old('desc') }}</textarea>
                @error('desc') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- Harga --}}
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" placeholder="Masukkan harga produk">
                @error('price') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            
            {{-- Gambar Produk --}}
            <div class="form-group">
                <label for="img">Gambar Produk Utama</label>
                <input type="file" id="img" name="img" class="form-control file-input @error('img') is-invalid @enderror">
                @error('img') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-actions mt-6">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Produk
                </button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
