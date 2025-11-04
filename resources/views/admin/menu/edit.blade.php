@extends('admin.layouts.app')

@section('title', 'Edit Konten Menu')

@section('content')
<div class="content">
    <div class="header-actions">
        <h2>Edit Konten: {{ $menu_data->title }}</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            *Gagal menyimpan data!* Mohon periksa kembali kolom isian di bawah.
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.menu_data.update', $menu_data->id) }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf 
            @method('PUT') 

            {{-- Pilihan Menu ID --}}
            <div class="form-group">
                <label for="menu_id">Menu Terkait</label>
                <select id="menu_id" name="menu_id" class="form-control @error('menu_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Menu Utama/Sub Menu --</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id }}" {{ old('menu_id', $menu_data->menu_id) == $menu->id ? 'selected' : '' }}>
                            {{ $menu->nama }} (Tipe: {{ $menu->tipe }})
                        </option>
                    @endforeach
                </select>
                @error('menu_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Judul (HAPUS 'required') --}}
            <div class="form-group">
                <label for="title">Judul Konten (Opsional)</label>
                {{-- *Hapus 'required' dari sini* --}}
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                        value="{{ old('title', $menu_data->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Isi Konten (LongText) (Pastikan tidak ada 'required') --}}
            <div class="form-group">
                <label for="content">Isi Konten (Opsional)</label>
                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $menu_data->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jenis Konten --}}
            <div class="form-group">
                <label for="jenis_konten">Jenis Konten (Opsional)</label>
                <input type="text" id="jenis_konten" name="jenis_konten" class="form-control @error('jenis_konten') is-invalid @enderror" 
                        value="{{ old('jenis_konten', $menu_data->jenis_konten) }}">
                @error('jenis_konten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Tanggal --}}
            <div class="form-group">
                <label for="date">Tanggal (Opsional)</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                        value="{{ old('date', $menu_data->date ? $menu_data->date->format('Y-m-d') : null) }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="form-group">
                <label for="location">Lokasi/Sumber (Opsional)</label>
                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                        value="{{ old('location', $menu_data->location) }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Link --}}
            <div class="form-group">
                <label for="link">Tautan Eksternal (Opsional)</label>
                <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" 
                        value="{{ old('link', $menu_data->link) }}">
                @error('link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Gambar --}}
            <div class="form-group">
                <label for="img">Gambar Utama (Opsional, Max 2MB)</label>
                <input type="file" id="img" name="img" class="form-control-file @error('img') is-invalid @enderror" accept="image/*">
                @if ($menu_data->img)
                    <p class="mt-2">Gambar saat ini: <a href="{{ asset('storage/' . $menu_data->img) }}" target="_blank">Lihat Gambar</a></p>
                @endif
                @error('img')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Abaikan jika tidak ingin mengganti gambar.</small>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui Konten
                </button>
                <a href="{{ route('admin.menu_data.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection