@extends('admin.layouts.app')

@section('title', 'Edit Toko') {{-- Tambahkan title section --}}

@section('content')
<style>
    /* ---------------------------------------------------------------- */
    /* CSS Kustom untuk Tata Letak 2 Kolom (Responsive) */
    /* ---------------------------------------------------------------- */
    .form-grid-2-column {
        display: flex;
        flex-wrap: wrap; 
        gap: 20px; /* Jarak antar kolom */
        margin-bottom: 10px; /* Jarak antar grup utama */
    }
    
    .form-grid-2-column .form-group {
        /* Memastikan setiap form-group mengambil setengah lebar (50% kurang sedikit karena ada gap) */
        flex: 1 1 calc(50% - 10px); 
        min-width: 250px; /* Minimum lebar agar tidak terlalu kecil di tablet */
    }
    
    /* Aturan untuk Layar Kecil (Mobile First): Menumpuk ke bawah */
    @media (max-width: 768px) {
        .form-grid-2-column {
            flex-direction: column;
            gap: 0;
            margin-bottom: 0; 
        }
        .form-grid-2-column .form-group {
            flex: 1 1 100%;
        }
    }

    /* Styling untuk divider yang lebih bersih */
    .form-section-header {
        margin-top: 30px; 
        margin-bottom: 15px; 
    }
    .form-section-header h4 {
        font-size: 1.2em; 
        color: #2c3e50; /* Warna judul yang lebih gelap/elegan */
        margin-bottom: 5px;
    }
    .form-section-header hr {
        border: 0;
        height: 1px;
        background-color: #dcdde1; /* Warna garis pemisah yang lebih soft */
        margin-top: 5px;
    }
    
    .form-buttons {
        margin-top: 30px;
    }
    
    /* Styling error message */
    .text-danger {
        color: #e74c3c;
        font-size: 0.9em;
        margin-top: 5px;
        display: block;
    }

</style>

<div class="content">
    <div class="header-actions">
        {{-- Judul dinamis --}}
        <h2>Edit Toko: {{ $store->name ?? 'Toko' }}</h2> 
    </div>

    <div class="form-card">
        {{-- ACTION diisi dengan route update toko, menggunakan ID toko --}}
        <form action="{{ route('admin.toko.update', $store->id) }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT') 

            <div class="form-section-header" style="margin-top: 0;">
                <h4>Informasi Utama</h4>
                <hr>
            </div>
            
            <div class="form-grid-2-column">
                <div class="form-group">
                    <label for="name">Nama Toko</label>
                    {{-- Menggunakan old() untuk fallback setelah error, atau $store->name --}}
                    <input type="text" id="name" name="name" class="form-control" 
                           value="{{ old('name', $store->name ?? '') }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Nomor WhatsApp</label>
                    {{-- Menggunakan 'telepon' sesuai nama kolom database --}}
                    <input type="text" id="telepon" name="telepon" class="form-control" 
                           value="{{ old('telepon', $store->telepon ?? '') }}">
                    @error('telepon')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section-header">
                <h4>Alamat Lengkap</h4>
                <hr>
            </div>
            
            <div class="form-group">
                <label for="alamat">Alamat</label>
                {{-- Menggunakan 'alamat' sesuai nama kolom database --}}
                <textarea id="alamat" name="alamat" class="form-control" rows="3" required>{{ old('alamat', $store->alamat ?? '') }}</textarea>
                @error('alamat')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.toko.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection