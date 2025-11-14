@extends('admin.layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="content">

    {{-- Header --}}
    <div class="header-actions">
        <h2>Edit Menu: {{ $menu->nama }}</h2>
    </div>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan data!</strong> Periksa kembali isian Anda.
        </div>
    @endif

    {{-- Form Card --}}
    <div class="form-card">
        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            {{-- Nama Menu --}}
            <div class="form-group">
                <label for="nama">Nama Menu <span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    class="form-control @error('nama') is-invalid @enderror" 
                    value="{{ old('nama', $menu->nama) }}" 
                    placeholder="Masukkan Nama Menu"
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
                    <option value="0" {{ old('parent_id', $menu->parent_id) == 0 ? 'selected' : '' }}>
                        Menu Utama
                    </option>

                    @foreach ($parentMenus as $parent)
                        @if ($parent->id != $menu->id)
                            <option 
                                value="{{ $parent->id }}" 
                                {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}
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
                <label for="urutan">Urutan Tampil <span class="text-danger">*</span></label>
                <input 
                    type="number" 
                    id="urutan" 
                    name="urutan" 
                    class="form-control @error('urutan') is-invalid @enderror" 
                    placeholder="Masukkan urutan menu"
                    value="{{ old('urutan', $menu->urutan) }}"
                    min="1"
                    required
                >
                @error('urutan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">* Urutan menentukan posisi menu dalam parent yang sama.</small>
            </div>

            {{-- STATUS --}}
            <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <div class="form-check-group">
                    <div class="form-check form-check-inline">
                        <input 
                            type="radio" 
                            name="status" 
                            value="aktif"
                            class="form-check-input"
                            {{ old('status', $menu->status) == 'aktif' ? 'checked' : '' }}
                        >
                        <label class="form-check-label">Aktif</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input 
                            type="radio" 
                            name="status" 
                            value="nonaktif"
                            class="form-check-input"
                            {{ old('status', $menu->status) == 'nonaktif' ? 'checked' : '' }}
                        >
                        <label class="form-check-label">Nonaktif</label>
                    </div>
                </div>
                @error('status')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui Menu
                </button>
                <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
