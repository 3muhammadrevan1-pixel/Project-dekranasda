@extends('admin.layouts.app')

@section('title', 'Edit Konten Menu')

@section('content')

@php
    // Parsing DATA ORGANISASI (format JSON)
    $orgData = [];
    $oldJabatan = old('jabatan', '');
    $oldDeskripsi = old('deskripsi_organisasi', '');

    if ($menu_data->jenis_konten === 'organisasi' && $menu_data->content) {
        $parsed = json_decode($menu_data->content, true);
        if (is_array($parsed) && !empty($parsed)) {
            $orgData = $parsed[0];
            $oldJabatan = old('jabatan', $orgData['jabatan'] ?? '');
            $oldDeskripsi = old('deskripsi_organisasi', $orgData['deskripsi'] ?? '');
        }
    }
@endphp

<div class="content">
    <div class="header-actions">
        <h2>Edit Konten Menu: {{ $menu_data->title }}</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan data!</strong> Mohon cek kembali kolom di bawah.
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.menu_data.update', $menu_data->id) }}"
              method="POST"
              class="form"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- MENU ID --}}
            <div class="form-group">
                <label for="menu_id">Menu Terkait</label>
                <select id="menu_id" name="menu_id" class="form-control" required>
                    <option value="">-- Pilih Menu Utama/Sub Menu --</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id }}"
                                data-content-type="{{ $menu->jenis_konten }}"
                                {{ old('menu_id', $menu_data->menu_id) == $menu->id ? 'selected' : '' }}>
                            {{ $menu->nama }} (Tipe: {{ $menu->jenis_konten }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JUDUL --}}
            <div class="form-group data-field" id="form-group-title">
                <label for="title">Judul Konten <span class="text-danger required-indicator">*</span></label>
                <input type="text" name="title" id="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $menu_data->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ISI KONTEN --}}
            <div class="form-group data-field" id="form-group-content">
                <label for="content">Isi Konten <span class="text-danger required-indicator">*</span></label>
                <textarea id="content" name="content" class="form-control" rows="5">{{ old('content', $menu_data->content) }}</textarea>
            </div>

            {{-- ORGANISASI --}}
            <div class="data-field" id="form-group-organisasi-custom" style="display:none;">
                <p class="text-info mt-3 font-weight-bold">Detail Struktur Organisasi</p>

                <div class="form-group">
                    <label for="jabatan">Jabatan <span class="text-danger required-indicator">*</span></label>
                    <input type="text" id="jabatan" name="jabatan"
                           class="form-control"
                           value="{{ $oldJabatan }}">
                </div>

                <div class="form-group">
                    <label for="deskripsi_organisasi">
                        Deskripsi Jabatan <span class="text-danger required-indicator">*</span>
                    </label>
                    <textarea id="deskripsi_organisasi" name="deskripsi_organisasi"
                              class="form-control" rows="3">{{ $oldDeskripsi }}</textarea>
                </div>
            </div>

            {{-- TANGGAL --}}
            <div class="form-group data-field" id="form-group-date">
                <label for="date">Tanggal</label>
                <input type="date" id="date" name="date"
                       class="form-control"
                       value="{{ old('date', $menu_data->date ? $menu_data->date->format('Y-m-d') : '') }}">
            </div>

            {{-- LOKASI --}}
            <div class="form-group data-field" id="form-group-location">
                <label for="location">Lokasi / Sumber</label>
                <input type="text" id="location" name="location"
                       class="form-control"
                       value="{{ old('location', $menu_data->location) }}">
            </div>

            {{-- LINK --}}
            <div class="form-group data-field" id="form-group-link">
                <label for="link">Tautan Eksternal</label>
                <input type="url" id="link" name="link"
                       class="form-control"
                       value="{{ old('link', $menu_data->link) }}">
            </div>

            {{-- GAMBAR --}}
            <div class="form-group data-field" id="form-group-img">
                <label for="img">Gambar Utama</label>
                <input type="file" id="img" name="img" class="form-control-file" accept="image/*">

                @if ($menu_data->img)
                    <p class="mt-2">
                        <a href="{{ asset('storage/'.$menu_data->img) }}" target="_blank">Lihat Gambar Saat Ini</a>
                    </p>
                @endif

                <small class="text-gray-500">Maksimal 2MB (JPG, JPEG, PNG, WEBP)</small>
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

{{-- JS DYNAMIC LOGIC (100% sama dengan create.blade.php) --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuSelect = document.getElementById('menu_id');
        const allFields = document.querySelectorAll('.data-field');
        const requiredIndicators = document.querySelectorAll('.required-indicator');

        const fieldMap = {
            'media': ['img'],
            'dinamis': ['title', 'content', 'date', 'location', 'link', 'img'],
            'organisasi': ['title', 'img', 'organisasi-custom'],
            'statis': ['title', 'content']
        };

        const requiredMap = {
            'media': ['img'],
            'dinamis': ['title', 'content'],
            'organisasi': ['title', 'jabatan', 'deskripsi_organisasi'],
            'statis': ['title', 'content']
        };

        function toggleFields() {
            const selected = menuSelect.options[menuSelect.selectedIndex];
            const type = selected ? selected.getAttribute('data-content-type') : '';
            const showFields = fieldMap[type] || [];
            const requiredFields = requiredMap[type] || [];

            allFields.forEach(group => {
                group.style.display = 'none';
                group.querySelectorAll('input, textarea').forEach(input => {
                    input.disabled = true;
                    input.removeAttribute('required');
                });
            });

            requiredIndicators.forEach(indicator => indicator.style.display = 'none');

            showFields.forEach(field => {
                const el = document.getElementById(`form-group-${field}`);
                if (el) {
                    el.style.display = 'block';
                    el.querySelectorAll('input, textarea').forEach(e => e.disabled = false);
                }
            });

            requiredFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.required = true;
                    const label = el.closest('.form-group').querySelector('label .required-indicator');
                    if (label) label.style.display = 'inline';
                }
            });
        }

        toggleFields();
        menuSelect.addEventListener('change', toggleFields);

        // Validasi gambar max 2MB
        document.getElementById('img').addEventListener('change', function () {
            const f = this.files[0];
            if (f && f.size > 2 * 1024 * 1024) {
                alert("Ukuran gambar melebihi 2MB!");
                this.value = "";
            }
        });
    });
</script>
@endsection
