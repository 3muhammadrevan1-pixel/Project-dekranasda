@extends('admin.layouts.app')

@section('content')

<div class="content">
<div class="header-actions">
<h2>Tambah Menu Baru</h2>
</div>

{{-- Pesan error validasi --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">
    {{-- Form mengarah ke MenuController@store --}}
    <form action="{{ route('admin.menu.store') }}" method="POST" class="form">
        @csrf

        {{-- Nama Menu --}}
        <div class="form-group">
            <label for="nama">Nama Menu <span class="text-danger">*</span></label>
            <input 
                type="text" 
                id="nama" 
                name="nama" 
                class="form-control @error('nama') is-invalid @enderror" 
                placeholder="Masukan Nama Menu" 
                value="{{ old('nama') }}" 
                required
            >
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Parent Menu --}}
        <div class="form-group">
            <label for="parent_id">Menu Induk (Parent)</label>
            <select 
                id="parent_id" 
                name="parent_id" 
                class="form-control @error('parent_id') is-invalid @enderror"
            >
                <option value="0" {{ old('parent_id') == 0 ? 'selected' : '' }}>Menu Utama</option>
                @foreach ($parentMenus as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->nama }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Urutan Tampil --}}
        <div class="form-group">
            <label for="urutan">Urutan Tampil <span class="text-danger">*</span></label>
            <input 
                type="number" 
                id="urutan" 
                name="urutan" 
                class="form-control @error('urutan') is-invalid @enderror" 
                placeholder="Masukan Urutan Menu(Navbar)" 
                value="{{ old('urutan') }}" 
                min="1" 
                required
            >
            @error('urutan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">* Urutan menentukan posisi menu di dalam parent yang sama.</small>
        </div>

        {{-- JENIS KONTEN (BARU: Menggantikan Tipe Menu) --}}
        <div class="form-group">
            <label for="jenis_konten">Jenis Konten <span class="text-danger">*</span></label>
            <select 
                id="jenis_konten" 
                name="jenis_konten" 
                class="form-control @error('jenis_konten') is-invalid @enderror" 
                required
            >
                <option value="">-- Pilih Jenis Konten untuk Menu Ini --</option>
                {{-- Loop melalui opsi yang dikirim dari controller --}}
                @foreach ($jenisKontenOptions as $key => $label) 
                    <option value="{{ $key }}" {{ old('jenis_konten') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('jenis_konten')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">* Jenis konten ini akan menentukan form apa yang tampil di halaman Konten Menu (misal: Statis hanya satu form, Media/Galeri bisa banyak postingan).</small>
        </div>
        
        {{-- HAPUS DIV Tipe Menu (radio button statis/dinamis) yang lama --}}
        
        {{-- Status --}}
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <div class="form-check-group">
                <div class="form-check form-check-inline">
                    <input 
                        class="form-check-input" 
                        type="radio" 
                        name="status" 
                        id="status_aktif" 
                        value="aktif" 
                        {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} 
                        required
                    >
                    <label class="form-check-label" for="status_aktif">Aktif</label>
                </div>
                <div class="form-check form-check-inline">
                    <input 
                        class="form-check-input" 
                        type="radio" 
                        name="status" 
                        id="status_nonaktif" 
                        value="nonaktif" 
                        {{ old('status') == 'nonaktif' ? 'checked' : '' }} 
                        required
                    >
                    <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                </div>
            </div>
            @error('status')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-buttons">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Menu
            </button>
            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </button>
            </a>
        </div>
    </form>
</div>


</div>
@endsection