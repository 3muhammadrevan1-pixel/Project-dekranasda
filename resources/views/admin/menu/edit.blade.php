@extends('admin.layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="content">

    {{-- Header --}}
    <div class="header-actions mb-6">
        <h2 class="text-2xl font-bold">Edit Menu: {{ $menu->nama }}</h2>
    </div>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-4 rounded-lg bg-red-100 text-red-700">
            <strong>Gagal menyimpan data!</strong> Mohon periksa kembali kolom isian di bawah.
        </div>
    @endif

    {{-- Form Card --}}
    <div class="form-card bg-white p-6 shadow rounded-xl">
        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            {{-- Nama Menu --}}
            <div class="form-group mb-4">
                <label for="nama" class="block font-medium text-gray-700 mb-1">Nama Menu</label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    value="{{ old('nama', $menu->nama) }}" 
                    placeholder="Contoh: Tentang Kami / Berita" 
                    required
                    class="form-control border rounded-lg w-full p-2 @error('nama') is-invalid @enderror"
                >
                @error('nama')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Menu Induk --}}
            <div class="form-group mb-4">
                <label for="parent_id" class="block font-medium text-gray-700 mb-1">Menu Induk (Parent)</label>
                <select 
                    id="parent_id" 
                    name="parent_id" 
                    class="form-control border rounded-lg w-full p-2 @error('parent_id') is-invalid @enderror"
                >
                    <option value="0" {{ old('parent_id', $menu->parent_id ?? 0) == 0 ? 'selected' : '' }}>
                        — Menu Utama (Top Level) —
                    </option>
                    @foreach ($parentMenus as $parent)
                        @if ($parent->id != $menu->id)
                            <option value="{{ $parent->id }}" 
                                {{ old('parent_id', $menu->parent_id ?? 0) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->nama }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Urutan --}}
            <div class="form-group mb-4">
                <label for="urutan" class="block font-medium text-gray-700 mb-1">Urutan Tampil (Opsional)</label>
                <input 
                    type="number" 
                    id="urutan" 
                    name="urutan" 
                    placeholder="Contoh: 1"
                    value="{{ old('urutan', $menu->urutan) }}"
                    class="form-control border rounded-lg w-full p-2 @error('urutan') is-invalid @enderror"
                >
                @error('urutan')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tipe Menu --}}
            <div class="form-group mb-4">
                <label class="block font-medium text-gray-700 mb-1">Tipe Menu</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="tipe" value="statis" 
                            {{ old('tipe', $menu->tipe) == 'statis' ? 'checked' : '' }} required
                            class="form-radio">
                        <span class="ml-2">Statis (Satu Halaman)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="tipe" value="dinamis" 
                            {{ old('tipe', $menu->tipe) == 'dinamis' ? 'checked' : '' }} required
                            class="form-radio">
                        <span class="ml-2">Dinamis (Postingan / Berita)</span>
                    </label>
                </div>
                @error('tipe')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group mb-4">
                <label class="block font-medium text-gray-700 mb-1">Status</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="aktif" 
                            {{ old('status', $menu->status) == 'aktif' ? 'checked' : '' }} required
                            class="form-radio">
                        <span class="ml-2">Aktif</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="nonaktif" 
                            {{ old('status', $menu->status) == 'nonaktif' ? 'checked' : '' }} required
                            class="form-radio">
                        <span class="ml-2">Nonaktif</span>
                    </label>
                </div>
                @error('status')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-buttons mt-6 flex gap-3">
                <button type="submit" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> Perbarui Menu
                </button>
                <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
