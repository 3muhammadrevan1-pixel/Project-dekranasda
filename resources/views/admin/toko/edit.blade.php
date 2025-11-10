@extends('admin.layouts.app')

@section('title', 'Edit Toko')

@section('content')
@php
    // Tentukan prefix route berdasarkan role saat ini
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<style>
    /* ---------------------------------------------------------------- */
    /* CSS Kustom untuk Tata Letak 2 Kolom (Responsive) */
    /* ---------------------------------------------------------------- */
    .form-grid-2-column {
        display: flex;
        flex-wrap: wrap; 
        gap: 20px;
        margin-bottom: 10px;
    }
    
    .form-grid-2-column .form-group {
        flex: 1 1 calc(50% - 10px); 
        min-width: 250px;
    }
    
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

    .form-section-header {
        margin-top: 30px; 
        margin-bottom: 15px; 
    }
    .form-section-header h4 {
        font-size: 1.2em; 
        color: #2c3e50; 
        margin-bottom: 5px;
    }
    .form-section-header hr {
        border: 0;
        height: 1px;
        background-color: #dcdde1; 
        margin-top: 5px;
    }
    
    .form-buttons {
        margin-top: 30px;
    }
    
    .text-danger {
        color: #e74c3c;
        font-size: 0.9em;
        margin-top: 5px;
        display: block;
    }
</style>

<div class="content">
    <div class="header-actions">
        <h2>Edit Toko: {{ $store->name ?? 'Toko' }}</h2> 
    </div>

    <div class="form-card">
        {{-- Form diarahkan ke route update toko sesuai role --}}
        <form action="{{ $rolePrefix === 'operator' 
                          ? route('operator.toko.update', $store) 
                          : route('admin.toko.update', $store) }}" 
              method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT') 

            <div class="form-section-header" style="margin-top: 0;">
                <h4>Informasi Utama</h4>
                <hr>
            </div>
            
            <div class="form-grid-2-column">
                <div class="form-group">
                    <label for="name">Nama Toko</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="{{ old('name', $store->name) }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Nomor WhatsApp</label>
                    <input type="text" id="telepon" name="telepon" class="form-control" 
                           value="{{ old('telepon', $store->telepon) }}">
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
                <textarea id="alamat" name="alamat" class="form-control" rows="3" required>{{ old('alamat', $store->alamat) }}</textarea>
                @error('alamat')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ $rolePrefix === 'operator' 
                             ? route('operator.toko.index') 
                             : route('admin.toko.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
