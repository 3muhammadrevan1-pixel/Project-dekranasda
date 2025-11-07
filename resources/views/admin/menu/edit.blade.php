@extends('admin.layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="content">
    <div class="header-actions">
        <h2>Edit Menu: {{ $menu->nama }}</h2>
    </div>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan data!</strong> Mohon periksa kembali kolom isian di bawah.
        </div>
    @endif

    <div class="form-card">
        {{-- Form mengarah ke MenuController@update --}}
        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" class="form">
            @csrf
            @method('PUT') {{-- Wajib untuk metode UPDATE --}}

            {{-- Nama Menu --}}
            <div class="form-group">
                <label for="nama">Nama Menu</label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    class="form-control @error('nama') is-invalid @enderror" 
                    value="{{ old('nama', $menu->nama) }}" 
                    placeholder="Contoh: Tentang Kami / Berita" 
                    required
                >
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Menu Induk --}}
            <div class="form-group">
                <label for="parent_id">Menu Induk (Parent)</label>
                <select 
                    id="parent_id" 
                    name="parent_id" 
                    class="form-control @error('parent_id') is-invalid @enderror"
                >
                    <option value="0" {{ old('parent_id', $menu->parent_id ?? 0) == 0 ? 'selected' : '' }}>
                        — Menu Utama (Top Level) —
                    </option>

                    {{-- Loop menu parent --}}
                    @foreach ($parentMenus as $parent)
                        @if ($parent->id != $menu->id)
                            <option 
                                value="{{ $parent->id }}" 
                                {{ old('parent_id', $menu->parent_id ?? 0) == $parent->id ? 'selected' : '' }}
                            >
                                {{ $parent->nama }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Urutan --}}
            <div class="form-group">
                <label for="urutan">Urutan Tampil (Opsional)</label>
                <input 
                    type="number" 
                    id="urutan" 
                    name="urutan" 
                    class="form-control @error('urutan') is-invalid @enderror" 
                    placeholder="Contoh: 1"
                    value="{{ old('urutan', $menu->urutan) }}"
                >
                @error('urutan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tipe Menu --}}
            <div class="form-group">
                <label for="tipe">Tipe Menu</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="tipe" 
                            id="tipe_statis" 
                            value="statis" 
                            {{ old('tipe', $menu->tipe) == 'statis' ? 'checked' : '' }} 
                            required
                        >
                        <label class="form-check-label" for="tipe_statis">Statis (Satu Halaman)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="tipe" 
                            id="tipe_dinamis" 
                            value="dinamis" 
                            {{ old('tipe', $menu->tipe) == 'dinamis' ? 'checked' : '' }} 
                            required
                        >
                        <label class="form-check-label" for="tipe_dinamis">Dinamis (Postingan / Berita)</label>
                    </div>
                </div>
                @error('tipe')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="status">Status</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="status" 
                            id="status_aktif" 
                            value="aktif" 
                            {{ old('status', $menu->status) == 'aktif' ? 'checked' : '' }} 
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
                            {{ old('status', $menu->status) == 'nonaktif' ? 'checked' : '' }} 
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
                    <i class="fas fa-save"></i> Perbarui Menu
                </button>
                <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsections