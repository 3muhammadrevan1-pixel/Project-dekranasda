@extends('admin.layouts.app')

@section('title', 'Edit Konten Menu')

@section('content')

@php
    // --- 1. PHP PRE-PARSING UNTUK DATA ORGANISASI ---
    $orgData = [];
    $oldJabatan = old('jabatan', '');
    $oldDeskripsi = old('deskripsi_organisasi', '');
    
    // Cek apakah data yang sedang diedit adalah jenis organisasi dan memiliki konten
    if ($menu_data->jenis_konten === 'organisasi' && $menu_data->content) {
        // Konten organisasi disimpan sebagai JSON string array: [{"jabatan":"...", "deskripsi":"..."}]
        $parsedContent = json_decode($menu_data->content, true);
        
        if (is_array($parsedContent) && !empty($parsedContent)) {
            // Ambil elemen pertama dari array
            $orgData = $parsedContent[0];
            
            // Set nilai default dari data yang sudah ada di database, jika tidak ada error validasi
            $oldJabatan = old('jabatan', $orgData['jabatan'] ?? '');
            $oldDeskripsi = old('deskripsi_organisasi', $orgData['deskripsi'] ?? '');
        }
    }
@endphp

<div class="content">
    <div class="header-actions">
        <h2>Edit Konten: {{ $menu_data->title }}</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan data!</strong> Mohon periksa kembali kolom isian di bawah.
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

            {{-- Jenis Konten (Driver) --}}
            <div class="form-group">
                <label for="jenis_konten">Jenis Konten</label>
                <select id="jenis_konten" name="jenis_konten" class="form-control @error('jenis_konten') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenis Konten --</option>
                    @foreach ($jenisKontenOptions as $key => $label)
                        <option value="{{ $key }}" {{ old('jenis_konten', $menu_data->jenis_konten) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_konten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- CONTAINER UNTUK FIELD YANG BERVARIASI --}}

            {{-- Judul (Hampir selalu ada, kecuali galeri) --}}
            <div class="form-group" id="title_field_container">
                <label for="title">Judul Konten</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                        value="{{ old('title', $menu_data->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Isi Konten (LongText, untuk Berita/Event/Halaman Biasa) --}}
            <div class="form-group" id="content_field_container">
                <label for="content">Isi Konten</label>
                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $menu_data->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- ⭐ FIELD KHUSUS UNTUK JENIS KONTEN 'ORGANISASI' (JSON data) ⭐ --}}
            <div id="organisasi_fields_container" style="display: none;">
                <h5 class="mt-4 mb-3">Detail Organisasi</h5>

                {{-- Jabatan --}}
                <div class="form-group">
                    <label for="jabatan">Jabatan/Posisi</label>
                    <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" 
                            value="{{ $oldJabatan }}">
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Deskripsi Organisasi --}}
                <div class="form-group">
                    <label for="deskripsi_organisasi">Deskripsi/Tugas Organisasi</label>
                    <textarea id="deskripsi_organisasi" name="deskripsi_organisasi" class="form-control @error('deskripsi_organisasi') is-invalid @enderror" rows="3">{{ $oldDeskripsi }}</textarea>
                    @error('deskripsi_organisasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- END FIELD ORGANISASI --}}

            {{-- Tanggal --}}
            <div class="form-group" id="date_field_container">
                <label for="date">Tanggal (Opsional)</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                        value="{{ old('date', $menu_data->date ? $menu_data->date->format('Y-m-d') : null) }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="form-group" id="location_field_container">
                <label for="location">Lokasi/Sumber (Opsional)</label>
                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                        value="{{ old('location', $menu_data->location) }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Link --}}
            <div class="form-group" id="link_field_container">
                <label for="link">Tautan Eksternal (Opsional)</label>
                <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" 
                        value="{{ old('link', $menu_data->link) }}">
                @error('link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Gambar --}}
            <div class="form-group" id="img_field_container">
                <label for="img">Gambar Utama</label>
                <input type="file" id="img" name="img" class="form-control-file @error('img') is-invalid @enderror" accept="image/*">
                @if ($menu_data->img)
                    <p class="mt-2">Gambar saat ini: <a href="{{ asset('storage/' . $menu_data->img) }}" target="_blank">Lihat Gambar</a></p>
                @endif
                @error('img')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted" id="img_help_text">Abaikan jika tidak ingin mengganti gambar.</small>
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui Konten
                </button>
                <a href="{{ route('admin.menu_data.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    // --- 2. JAVASCRIPT UNTUK DYNAMIC FORM ---
    document.addEventListener('DOMContentLoaded', function () {
        const jenisKontenSelect = document.getElementById('jenis_konten');
        
        // Containers (menggunakan IDs yang sudah ditambahkan)
        const titleContainer = document.getElementById('title_field_container');
        const contentContainer = document.getElementById('content_field_container');
        const organisasiContainer = document.getElementById('organisasi_fields_container');
        const dateContainer = document.getElementById('date_field_container');
        const locationContainer = document.getElementById('location_field_container');
        const linkContainer = document.getElementById('link_field_container');
        const imgContainer = document.getElementById('img_field_container');
        
        // Input Fields (untuk required state)
        const titleInput = document.getElementById('title');
        const contentTextarea = document.getElementById('content');
        const jabatanInput = document.getElementById('jabatan');
        const deskripsiTextarea = document.getElementById('deskripsi_organisasi');
        const imgInput = document.getElementById('img');
        const imgHelpText = document.getElementById('img_help_text');

        function toggleFields() {
            const selectedType = jenisKontenSelect.value;

            // Atur default visible/hidden
            titleContainer.style.display = 'none';
            contentContainer.style.display = 'none';
            organisasiContainer.style.display = 'none';
            dateContainer.style.display = 'none';
            locationContainer.style.display = 'none';
            linkContainer.style.display = 'none';
            imgContainer.style.display = 'none';

            // Reset required state
            titleInput.removeAttribute('required');
            contentTextarea.removeAttribute('required');
            jabatanInput.removeAttribute('required');
            deskripsiTextarea.removeAttribute('required');
            imgInput.removeAttribute('required');
            imgHelpText.textContent = 'Abaikan jika tidak ingin mengganti gambar.'; // Default help text

            if (selectedType === 'galeri') {
                // GALERI: Hanya butuh Gambar
                imgContainer.style.display = 'block';
                // Pada edit, input file tidak required, tapi kita harus pastikan ada gambar lama
                // Aturan required diserahkan ke Controller (Rule::requiredIf)
                imgHelpText.textContent = 'Wajib upload gambar baru jika gambar lama dihapus/kosong.'; 

            } else if (selectedType === 'berita') {
                // BERITA: Title, Content, Date, Location, Gambar
                titleContainer.style.display = 'block';
                contentContainer.style.display = 'block';
                dateContainer.style.display = 'block';
                locationContainer.style.display = 'block';
                imgContainer.style.display = 'block';
                
                titleInput.setAttribute('required', 'required');
                contentTextarea.setAttribute('required', 'required');
                
            } else if (selectedType === 'event') {
                // EVENT: Title, Content, Date, Location, Link, Gambar
                titleContainer.style.display = 'block';
                contentContainer.style.display = 'block';
                dateContainer.style.display = 'block';
                locationContainer.style.display = 'block';
                linkContainer.style.display = 'block';
                imgContainer.style.display = 'block';
                
                titleInput.setAttribute('required', 'required');
                contentTextarea.setAttribute('required', 'required');
                linkContainer.querySelector('label').textContent = 'Tautan Eksternal (Wajib)'; // Ubah label link
                
            } else if (selectedType === 'organisasi') {
                // ORGANISASI: Title, Jabatan, Deskripsi Organisasi, Gambar
                titleContainer.style.display = 'block';
                organisasiContainer.style.display = 'block';
                imgContainer.style.display = 'block';

                titleInput.setAttribute('required', 'required');
                jabatanInput.setAttribute('required', 'required');
                deskripsiTextarea.setAttribute('required', 'required');
                
            } else if (selectedType === 'link') {
                // LINK: Hanya butuh Link dan Title (jika ada)
                titleContainer.style.display = 'block';
                linkContainer.style.display = 'block';
                
            } else if (selectedType) {
                // Tipe Lain (Default/Halaman Biasa): Title, Content, dan lainnya Opsional
                titleContainer.style.display = 'block';
                contentContainer.style.display = 'block';
                dateContainer.style.display = 'block';
                locationContainer.style.display = 'block';
                linkContainer.style.display = 'block';
                imgContainer.style.display = 'block';
                
                // Biasanya hanya title/content yang required untuk page biasa
                // Title dan Content bisa jadi optional tergantung implementasi, tapi kita anggap required untuk page
                titleInput.setAttribute('required', 'required');
                contentTextarea.setAttribute('required', 'required');
            }
        }

        // Jalankan saat halaman dimuat
        toggleFields();

        // Jalankan saat Jenis Konten diubah
        jenisKontenSelect.addEventListener('change', toggleFields);
    });
</script>
@endsection
