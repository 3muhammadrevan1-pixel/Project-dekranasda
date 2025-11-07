@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<div class="content">

```
{{-- Notifikasi Error --}}
@if (session('error'))
    <div class="alert alert-error mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="form-card">
    {{-- Form Tambah Produk --}}
    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf

        {{-- Nama Produk --}}
        <div class="form-group">
            <label for="name">Nama Produk <span class="required">*</span></label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                class="form-control @error('name') is-invalid @enderror" 
                placeholder="Masukkan nama produk"
            >
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Toko --}}
        <div class="form-group">
            <label for="store_id">Toko <span class="required">*</span></label>
            <select 
                id="store_id" 
                name="store_id" 
                required 
                class="form-control @error('store_id') is-invalid @enderror"
            >
                <option value="">-- Pilih Toko --</option>
                @foreach ($stores as $store)
                    <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
            @error('store_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Kategori & Tipe Produk --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Kategori --}}
            <div class="form-group">
                <label for="category">Kategori</label>
                <select 
                    id="category" 
                    name="category" 
                    class="form-control @error('category') is-invalid @enderror"
                >
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Unggulan" {{ old('category') == 'Unggulan' ? 'selected' : '' }}>Unggulan</option>
                    <option value="Terbaru" {{ old('category') == 'Terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="Kerajinan Kayu" {{ old('category') == 'Kerajinan Kayu' ? 'selected' : '' }}>Kerajinan Kayu</option>
                </select>
                @error('category')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tipe Produk --}}
            <div class="form-group">
                <label for="type">Tipe Produk</label>
                <select 
                    id="type" 
                    name="type" 
                    class="form-control @error('type') is-invalid @enderror"
                >
                    <option value="">-- Pilih Tipe --</option>
                    <option value="None" {{ old('type') == 'None' ? 'selected' : '' }}>None</option>
                    <option value="Sepatu" {{ old('type') == 'Sepatu' ? 'selected' : '' }}>Sepatu</option>
                    <option value="Baju" {{ old('type') == 'Baju' ? 'selected' : '' }}>Baju</option>
                </select>
                @error('type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Warna --}}
        <div class="form-group" id="color-input" style="display: none;">
            <label for="color">Warna Varian Utama <span class="required">*</span></label>
            <input 
                type="text" 
                id="color" 
                name="color" 
                value="{{ old('color') }}" 
                class="form-control @error('color') is-invalid @enderror" 
                placeholder="Contoh: Merah, Hitam"
            >
            @error('color')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Ukuran Sepatu --}}
        <div class="form-group" id="size-input-numeric" style="display: none;">
            <label for="sizes_numeric">Ukuran (Sepatu) <span class="required">*</span></label>
            <input 
                type="text" 
                id="sizes_numeric" 
                name="sizes_numeric_disabled" 
                value="{{ old('sizes') }}" 
                class="form-control @error('sizes') is-invalid @enderror" 
                placeholder="Masukkan ukuran angka, pisahkan dengan koma (Contoh: 38,39,40)" 
                pattern="^[\d,]+$" 
                title="Hanya angka dan koma yang diizinkan."
            >
            @error('sizes')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Ukuran Baju --}}
        <div class="form-group" id="size-input-text" style="display: none;">
            <label for="sizes_text">Ukuran (Baju) <span class="required">*</span></label>
            <input 
                type="text" 
                id="sizes_text" 
                name="sizes_text_disabled" 
                value="{{ old('sizes') }}" 
                class="form-control @error('sizes') is-invalid @enderror" 
                placeholder="Masukkan ukuran huruf, pisahkan dengan koma (Contoh: S,M,L,XL)" 
                pattern="^[\w\s,]+$" 
                title="Hanya huruf, spasi, dan koma yang diizinkan."
            >
            @error('sizes')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="form-group">
            <label for="desc">Deskripsi</label>
            <textarea 
                id="desc" 
                name="desc" 
                rows="4" 
                class="form-control @error('desc') is-invalid @enderror" 
                placeholder="Masukkan deskripsi produk"
            >{{ old('desc') }}</textarea>
            @error('desc')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Harga --}}
        <div class="form-group">
            <label for="price">Harga</label>
            <input 
                type="number" 
                id="price" 
                name="price" 
                step="0.01" 
                value="{{ old('price') }}" 
                class="form-control @error('price') is-invalid @enderror" 
                placeholder="Masukkan harga produk"
            >
            @error('price')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Gambar Produk --}}
        <div class="form-group">
            <label for="img">Gambar Produk Utama</label>
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
                <i class="fas fa-save"></i> Simpan Produk
            </button>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
```

</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const colorInputGroup = document.getElementById('color-input');
    const colorInput = document.getElementById('color');
    const sizeNumericGroup = document.getElementById('size-input-numeric');
    const sizeNumericInput = document.getElementById('sizes_numeric');
    const sizeTextGroup = document.getElementById('size-input-text');
    const sizeTextInput = document.getElementById('sizes_text');

    function updateSizeFields(selectedType) {
        // Reset semua field
        [sizeNumericGroup, sizeTextGroup, colorInputGroup].forEach(el => el.style.display = 'none');
        [sizeNumericInput, sizeTextInput, colorInput].forEach(el => el.removeAttribute('required'));

        // Nonaktifkan nama input agar tidak ikut terkirim
        sizeNumericInput.name = 'sizes_numeric_disabled';
        sizeTextInput.name = 'sizes_text_disabled';

        if (selectedType === 'Sepatu') {
            colorInputGroup.style.display = 'block';
            sizeNumericGroup.style.display = 'block';
            colorInput.required = true;
            sizeNumericInput.required = true;
            sizeNumericInput.name = 'sizes';
        } 
        else if (selectedType === 'Baju') {
            colorInputGroup.style.display = 'block';
            sizeTextGroup.style.display = 'block';
            colorInput.required = true;
            sizeTextInput.required = true;
            sizeTextInput.name = 'sizes';
        } 
        else if (selectedType === 'None' && selectedType !== '') {
            colorInputGroup.style.display = 'block';
            colorInput.required = true;
        }
    }

    // Validasi input sepatu (hanya angka dan koma)
    sizeNumericInput.addEventListener('input', e => {
        e.target.value = e.target.value.replace(/[^0-9,]/g, '');
    });

    // Validasi input baju (hanya huruf, angka, spasi, koma)
    sizeTextInput.addEventListener('input', e => {
        e.target.value = e.target.value.replace(/[^a-zA-Z0-9\s,]/g, '');
    });

    // Jalankan saat tipe berubah
    typeSelect.addEventListener('change', function () {
        updateSizeFields(this.value);
    });

    // Jalankan saat halaman pertama kali dimuat
    updateSizeFields(typeSelect.value);
});
</script>

