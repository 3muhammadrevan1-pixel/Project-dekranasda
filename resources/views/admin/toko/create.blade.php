@extends('admin.layouts.app')

@section('title', 'Tambah Toko')

@section('content')

<div class="content">
    <h2>Tambah Toko</h2>

    {{-- Notifikasi Error/Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada masalah dengan input Anda:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form diarahkan ke StoreController@store --}}
    <form action="{{ route('admin.toko.store') }}" method="POST" class="form-card">
        @csrf {{-- Token Keamanan Laravel --}}

        <div class="form-group">
            <label for="name">Nama Toko <span class="required">*</span></label>
            {{-- value="{{ old('name') }}" mempertahankan input jika validasi gagal --}}
            <input type="text" id="name" name="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   placeholder="Masukkan nama toko" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" 
                      class="form-control @error('alamat') is-invalid @enderror" 
                      placeholder="Masukkan alamat toko">{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telepon">No. WhatsApp</label>
            {{-- Nama input harus sesuai dengan kolom database: 'telepon' --}}
            <input type="text" id="telepon" name="telepon" 
                   class="form-control @error('telepon') is-invalid @enderror" 
                   placeholder="Contoh: 081234567890 atau 6281234567890" value="{{ old('telepon') }}">
            @error('telepon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

         <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Menu
                </button>
                <a href="{{ route('admin.toko.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
    </form>
</div>

@endsection