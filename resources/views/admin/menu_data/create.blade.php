@extends('admin.layouts.app')

@section('title', 'Tambah Konten Menu Baru')

@section('content')
<div class="content">
    <div class="header-actions">
        <h2>Tambah Konten Menu Baru</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan data!</strong> Mohon periksa kembali kolom isian di bawah.
        </div>
    @endif

    <div class="form-card">
        {{-- Harus menambahkan enctype="multipart/form-data" karena ada upload file (img) --}}
        <form action="{{ route('admin.menu_data.store') }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf 

            {{-- Pilihan Menu ID (Wajib) --}}
            <div class="form-group">
                <label for="menu_id">Menu Terkait</label>
                {{-- Tambahkan onchange untuk memicu JavaScript toggle --}}
                <select id="menu_id" name="menu_id" class="form-control @error('menu_id') is-invalid @enderror" required>
                    <option value="" data-content-type="">-- Pilih Menu Utama/Sub Menu --</option>
                    @foreach ($menus as $menu)
                        {{-- Menyimpan jenis_konten di data attribute agar bisa dibaca JS --}}
                        <option value="{{ $menu->id }}" 
                                data-content-type="{{ $menu->jenis_konten }}"
                                {{ (old('menu_id') == $menu->id || ($selectedMenu && $selectedMenu->id == $menu->id)) ? 'selected' : '' }}>
                            {{ $menu->nama }} (Tipe: {{ $menu->jenis_konten }})
                        </option>
                    @endforeach
                </select>
                @error('menu_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Jenis konten akan otomatis disesuaikan dengan menu yang dipilih.</small>
            </div>
            
            {{-- Semua field yang bisa disembunyikan/ditampilkan diberi class 'data-field' dan ID --}}
            
            {{-- Judul --}}
            <div class="form-group data-field" id="form-group-title" style="display: none;">
                <label for="title">Judul Konten <span class="text-danger required-indicator">*</span></label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                        placeholder="Judul Konten" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Isi Konten (LongText) --}}
            <div class="form-group data-field" id="form-group-content" style="display: none;">
                <label for="content">Isi Konten <span class="text-danger required-indicator">*</span></label>
                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ⭐ FIELD KHUSUS UNTUK ORGANISASI (Jabatan & Deskripsi) ⭐ --}}
            <div class="data-field" id="form-group-organisasi-custom" style="display: none;">
                <p class="text-info mt-3 font-weight-bold">Detail Struktur Organisasi</p>
                {{-- Jabatan --}}
                <div class="form-group">
                    <label for="jabatan">Jabatan <span class="text-danger required-indicator">*</span></label>
                    <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" 
                            placeholder="Contoh: Ketua, Bendahara, Anggota" value="{{ old('jabatan') }}">
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Deskripsi Organisasi --}}
                <div class="form-group">
                    <label for="deskripsi_organisasi">Deskripsi / Detail Jabatan <span class="text-danger required-indicator">*</span></label>
                    <textarea id="deskripsi_organisasi" name="deskripsi_organisasi" class="form-control @error('deskripsi_organisasi') is-invalid @enderror" rows="3">{{ old('deskripsi_organisasi') }}</textarea>
                    @error('deskripsi_organisasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- ⭐ END FIELD KHUSUS ORGANISASI ⭐ --}}
            
            {{-- Tanggal --}}
            <div class="form-group data-field" id="form-group-date" style="display: none;">
                <label for="date">Tanggal (Opsional)</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                        value="{{ old('date') }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="form-group data-field" id="form-group-location" style="display: none;">
                <label for="location">Lokasi/Sumber (Opsional)</label>
                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                        value="{{ old('location') }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Link --}}
            <div class="form-group data-field" id="form-group-link" style="display: none;">
                <label for="link">Tautan Eksternal <span class="text-danger required-indicator"></span></label>
                <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" 
                        placeholder="https://example.com" value="{{ old('link') }}">
                @error('link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Gambar --}}
            <div class="form-group data-field" id="form-group-img" style="display: none;">
                <label for="img">Gambar Utama <span class="text-danger required-indicator"></span> (Max 2MB)</label>
                <input type="file" id="img" name="img" class="form-control-file @error('img') is-invalid @enderror" accept="image/*">
                <small class="text-gray-500 text-sm">Ukuran maksimal 2MB (format JPG, PNG, JPEG, WEBP)</small>
                @error('img')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Konten
                </button>
                <a href="{{ route('admin.menu_data.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuIdSelect = document.getElementById('menu_id');
        const allToggleFields = document.querySelectorAll('.data-field');
        const requiredIndicators = document.querySelectorAll('.required-indicator');

        // --- START PERBAIKAN LOGIKA UTAMA (HANYA MEDIA MUNCULKAN GAMBAR) ---

        // Mapping jenis_konten ke ID field yang harus ditampilkan
        const fieldMap = {
            'media': ['img'], // DIPERBAIKI: HANYA tampilkan gambar untuk jenis media
            'dinamis': ['title', 'content', 'date', 'location', 'link', 'img'], 
            'organisasi': ['title', 'img', 'organisasi-custom'], 
            'statis': ['title', 'content'], 
        };
        
        // Mapping jenis_konten ke ID input/textarea yang wajib diisi (untuk client-side required attribute)
        const requiredFieldsMap = {
            'media': ['img'], // 'img' wajib
            'dinamis': ['title', 'content'], // HANYA title dan content yang wajib, link, date, location opsional
            'organisasi': ['title', 'jabatan', 'deskripsi_organisasi'],
            'statis': ['title', 'content'],
        };
        
        // --- END PERBAIKAN LOGIKA UTAMA ---

        function toggleFields() {
            const selectedOption = menuIdSelect.options[menuIdSelect.selectedIndex];
            const selectedType = selectedOption ? selectedOption.getAttribute('data-content-type') : '';
            const fieldsToShow = fieldMap[selectedType] || [];
            const clientRequiredFields = requiredFieldsMap[selectedType] || [];
            
            // 1. Reset semua field
            allToggleFields.forEach(fieldGroup => {
                // Sembunyikan dan disable semua field
                fieldGroup.style.display = 'none';
                fieldGroup.querySelectorAll('input, textarea, select, [required]').forEach(input => {
                    input.setAttribute('disabled', 'disabled');
                    input.removeAttribute('required');
                });
            });

            // 2. Sembunyikan semua indikator wajib
            requiredIndicators.forEach(indicator => {
                indicator.style.display = 'none';
            });


            // 3. Tampilkan field yang relevan dan atur required/disabled
            if (selectedType) {
                fieldsToShow.forEach(fieldName => {
                    const fieldGroup = document.getElementById(`form-group-${fieldName}`);
                    if (fieldGroup) {
                        fieldGroup.style.display = 'block';
                        
                        // Aktifkan semua input di dalam form group yang ditampilkan
                        fieldGroup.querySelectorAll('input, textarea, select').forEach(input => {
                            input.removeAttribute('disabled');
                        });
                    }
                });

                // 4. Set attribute required untuk field yang wajib
                clientRequiredFields.forEach(inputName => {
                    const inputElement = document.getElementById(inputName);
                    if (inputElement) {
                        inputElement.setAttribute('required', 'required');
                        
                        // Tampilkan indikator * wajib
                        const container = inputElement.closest('.form-group') || inputElement.closest('#form-group-organisasi-custom > .form-group');
                        const label = container?.querySelector('label');
                        const indicator = label?.querySelector('.required-indicator');
                        if (indicator) {
                            indicator.style.display = 'inline';
                        }
                    }
                });
                
                // 5. Khusus untuk Dinamis, pastikan Link, Date, Location, Img tidak required
                if (selectedType === 'dinamis') {
                    ['link', 'date', 'location', 'img'].forEach(name => {
                        const inputEl = document.getElementById(name);
                        if (inputEl) {
                            inputEl.removeAttribute('required');
                            const label = inputEl.closest('.form-group')?.querySelector('label');
                            const indicator = label?.querySelector('.required-indicator');
                            if (indicator) {
                                indicator.style.display = 'none';
                            }
                        }
                    });
                }
            }
        }

        // Jalankan saat page load (untuk menangani old() data saat validasi gagal)
        toggleFields(); 
        menuIdSelect.addEventListener('change', toggleFields);

        // 🔹 Validasi ukuran gambar maksimal 2MB
        const imgInput = document.getElementById('img');
        if (imgInput) {
            imgInput.addEventListener('change', function () {
                // Hapus feedback sebelumnya
                this.closest('.form-group').querySelectorAll('.alert-warning').forEach(el => el.remove());
                
                const file = this.files[0];
                if (file && file.size > 2 * 1024 * 1024) {
                    const feedback = document.createElement('div');
                    feedback.className = 'alert alert-warning mt-2';
                    feedback.textContent = 'Ukuran gambar melebihi 2MB! Silakan pilih gambar yang lebih kecil.';
                    this.closest('.form-group').appendChild(feedback);

                    setTimeout(() => feedback.remove(), 5000);
                    this.value = '';
                }
            });
        }
    });
</script>
@endsection