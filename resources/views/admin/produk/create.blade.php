@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<div class="content">

{{-- Notifikasi Error --}}
@if (session('error'))
    <div class="alert alert-error mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="form-card">
    {{-- Tentukan role prefix --}}
    @php
        $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
    @endphp

    {{-- Form Tambah Produk --}}
    <form action="{{ route($rolePrefix . '.produk.store') }}" method="POST" enctype="multipart/form-data" class="form" id="product-form">
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
            <div class="form-group relative">
                <label for="category">Kategori <span class="required">*</span></label>
                <div class="flex gap-2">
                    <select 
                        id="category" 
                        name="category" 
                        required
                        class="form-control @error('category') is-invalid @enderror flex-1"
                    >
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Fashion" {{ old('category') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                        <option value="Kerajinan" {{ old('category') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                    </select>
                    <button type="button" id="add-category-btn" class="btn btn-secondary" style="white-space: nowrap;">
                        + Tambah
                    </button>
                </div>
                @error('category')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                {{-- Input tambah kategori --}}
                <div id="new-category-container" style="display:none; margin-top:8px;">
                    <input 
                        type="text" 
                        id="new-category-input" 
                        class="form-control" 
                        placeholder="Nama kategori baru"
                    >
                    <div class="flex gap-2 mt-2">
                        <button type="button" id="save-category-btn" class="btn btn-primary btn-sm">Simpan</button>
                        <button type="button" id="cancel-category-btn" class="btn btn-secondary btn-sm">Batal</button>
                    </div>
                </div>
            </div>

            {{-- Tipe Produk --}}
            <div class="form-group">
                <label for="type">Tipe Produk Variant <span class="required">*</span></label>
                <select 
                    id="type" 
                    name="type" 
                    class="form-control @error('type') is-invalid @enderror"
                    required
                >
                    <option value="">-- Pilih Tipe --</option>
                    <option value="warna_angka" {{ old('type') == 'warna_angka' ? 'selected' : '' }}>Warna + Angka</option>
                    <option value="warna_huruf" {{ old('type') == 'warna_huruf' ? 'selected' : '' }}>Warna + Huruf</option>
                    <option value="warna" {{ old('type') == 'warna' ? 'selected' : '' }}>Warna</option>
                    <option value="tunggal" {{ old('type') == 'tunggal' ? 'selected' : '' }}>Tunggal</option>
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

        {{-- Ukuran Angka --}}
        <div class="form-group" id="size-input-numeric" style="display: none;">
            <label for="sizes_numeric">Ukuran (Angka) <span class="required">*</span></label>
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

        {{-- Ukuran Huruf --}}
        <div class="form-group" id="size-input-text" style="display: none;">
            <label for="sizes_text">Ukuran (Huruf) <span class="required">*</span></label>
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
            <label for="price">Harga <span class="required">*</span></label>
            <input 
                type="number" 
                id="price" 
                name="price" 
                step="0.01" 
                value="{{ old('price') }}" 
                class="form-control @error('price') is-invalid @enderror" 
                placeholder="Masukkan harga produk"
                required
            >
            @error('price')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Gambar Produk --}}
        <div class="form-group">
            <label for="img">Gambar Produk Utama <span class="required">*</span></label>
            <input 
                type="file" 
                id="img" 
                name="img" 
                class="form-control file-input @error('img') is-invalid @enderror"
                required
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
            <a href="{{ route($rolePrefix . '.produk.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

</div>
@endsection

{{-- Script Dinamis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const colorInputGroup = document.getElementById('color-input');
    const colorInput = document.getElementById('color');
    const sizeNumericGroup = document.getElementById('size-input-numeric');
    const sizeNumericInput = document.getElementById('sizes_numeric');
    const sizeTextGroup = document.getElementById('size-input-text');
    const sizeTextInput = document.getElementById('sizes_text');
    const productForm = document.getElementById('product-form');
    const priceInput = document.getElementById('price');

    // Tombol tambah kategori
    const addCategoryBtn = document.getElementById('add-category-btn');
    const newCategoryContainer = document.getElementById('new-category-container');
    const newCategoryInput = document.getElementById('new-category-input');
    const saveCategoryBtn = document.getElementById('save-category-btn');
    const cancelCategoryBtn = document.getElementById('cancel-category-btn');
    const categorySelect = document.getElementById('category');

    addCategoryBtn.addEventListener('click', () => {
        newCategoryContainer.style.display = 'block';
        newCategoryInput.focus();
    });
    cancelCategoryBtn.addEventListener('click', () => {
        newCategoryContainer.style.display = 'none';
        newCategoryInput.value = '';
    });
    saveCategoryBtn.addEventListener('click', () => {
        const newCat = newCategoryInput.value.trim();
        if (!newCat) return alert('Nama kategori tidak boleh kosong!');
        const exists = Array.from(categorySelect.options).some(opt => opt.value.toLowerCase() === newCat.toLowerCase());
        if (exists) { alert('Kategori sudah ada!'); return; }
        const option = new Option(newCat, newCat, true, true);
        categorySelect.add(option);
        newCategoryContainer.style.display = 'none';
        newCategoryInput.value = '';
    });

    function updateSizeFields(selectedType) {
        [sizeNumericGroup, sizeTextGroup, colorInputGroup].forEach(el => el.style.display = 'none');
        [colorInput, sizeNumericInput, sizeTextInput].forEach(el => el.removeAttribute('required'));
        sizeNumericInput.name = 'sizes_numeric_disabled';
        sizeTextInput.name = 'sizes_text_disabled';

        switch (selectedType) {
            case 'warna_angka':
                colorInputGroup.style.display = 'block';
                sizeNumericGroup.style.display = 'block';
                colorInput.required = true;
                sizeNumericInput.required = true;
                sizeNumericInput.name = 'sizes';
                break;
            case 'warna_huruf':
                colorInputGroup.style.display = 'block';
                sizeTextGroup.style.display = 'block';
                colorInput.required = true;
                sizeTextInput.required = true;
                sizeTextInput.name = 'sizes';
                break;
            case 'warna':
                colorInputGroup.style.display = 'block';
                colorInput.required = true;
                break;
        }
    }

    typeSelect.addEventListener('change', function () {
        updateSizeFields(this.value);
    });
    updateSizeFields(typeSelect.value);

    // Validasi sebelum submit
    productForm.addEventListener('submit', function(e) {
        let errors = [];
        const type = typeSelect.value;
        const imgInput = document.getElementById('img');

        if (!imgInput.value) errors.push('Gambar produk wajib diisi!');
        if (!priceInput.value) errors.push('Harga produk wajib diisi!');

        if (type === 'warna_angka') {
            const sizes = sizeNumericInput.value.trim();
            if (!sizes) errors.push('Ukuran angka wajib diisi!');
            else if (/[^0-9,]/.test(sizes)) errors.push('Ukuran angka hanya boleh angka dan koma!');
        } else if (type === 'warna_huruf') {
            const sizes = sizeTextInput.value.trim();
            if (!sizes) errors.push('Ukuran huruf wajib diisi!');
            else if (/[^a-zA-Z\s,]/.test(sizes)) errors.push('Ukuran huruf hanya boleh huruf, spasi, dan koma!');
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });

});
</script>
