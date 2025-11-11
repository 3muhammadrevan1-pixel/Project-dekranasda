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

            {{-- Pilihan Menu ID --}}
            <div class="form-group">
                <label for="menu_id">Menu Terkait</label>
                <select id="menu_id" name="menu_id" class="form-control @error('menu_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Menu Utama/Sub Menu --</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>
                            {{ $menu->nama }} (Tipe: {{ $menu->tipe }})
                        </option>
                    @endforeach
                </select>
                @error('menu_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Jenis Konten --}}
            <div class="form-group">
                <label for="jenis_konten">Jenis Konten</label>
                <select id="jenis_konten" name="jenis_konten" class="form-control @error('jenis_konten') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenis Konten --</option>
                    @foreach ($jenisKontenOptions as $key => $label)
                        <option value="{{ $key }}" {{ old('jenis_konten') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_konten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Semua field yang bisa disembunyikan/ditampilkan diberi class 'data-field' dan ID --}}
            
            {{-- Judul --}}
            <div class="form-group data-field" id="form-group-title">
                <label for="title">Judul Konten</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                        placeholder="Judul Konten" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Isi Konten (LongText) - Digunakan untuk Berita/Event/Teks biasa --}}
            <div class="form-group data-field" id="form-group-content">
                <label for="content">Isi Konten</label>
                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ⭐ FIELD KHUSUS UNTUK ORGANISASI (Jabatan & Deskripsi) ⭐ --}}
            <div class="data-field" id="form-group-organisasi-custom">
                {{-- Jabatan --}}
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    {{-- Nama field harus berbeda dari kolom DB agar tidak bentrok dengan 'content' --}}
                    <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" 
                            placeholder="Contoh: Ketua, Bendahara, Anggota" value="{{ old('jabatan') }}">
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Deskripsi Organisasi --}}
                <div class="form-group">
                    <label for="deskripsi_organisasi">Deskripsi / Detail Jabatan</label>
                    {{-- Nama field harus berbeda dari kolom DB --}}
                    <textarea id="deskripsi_organisasi" name="deskripsi_organisasi" class="form-control @error('deskripsi_organisasi') is-invalid @enderror" rows="3">{{ old('deskripsi_organisasi') }}</textarea>
                    @error('deskripsi_organisasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- ⭐ END FIELD KHUSUS ORGANISASI ⭐ --}}
            
            {{-- Tanggal --}}
            <div class="form-group data-field" id="form-group-date">
                <label for="date">Tanggal (Opsional)</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                        value="{{ old('date') }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="form-group data-field" id="form-group-location">
                <label for="location">Lokasi/Sumber (Opsional)</label>
                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                        value="{{ old('location') }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Link --}}
            <div class="form-group data-field" id="form-group-link">
                <label for="link">Tautan Eksternal (Opsional)</label>
                <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" 
                        placeholder="https://example.com" value="{{ old('link') }}">
                @error('link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Gambar --}}
            <div class="form-group data-field" id="form-group-img">
                <label for="img">Gambar Utama (Opsional, Max 2MB)</label>
                <input type="file" id="img" name="img" class="form-control-file @error('img') is-invalid @enderror" accept="image/*">
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
        const jenisKontenSelect = document.getElementById('jenis_konten');
        // Kumpulkan semua form group yang bisa di-toggle, termasuk grup khusus organisasi
        const allToggleFields = document.querySelectorAll('.data-field');
        
        // Definisikan field mana saja yang HARUS muncul untuk setiap jenis konten
        // Gunakan nama field/ID form group yang sudah kita buat
        const fieldMap = {
            'galeri': ['img'], // Hanya Gambar
            'berita': ['title', 'content', 'date', 'location', 'img'],
            'event': ['title', 'content', 'date', 'location', 'img', 'link'],
            // ⭐ Khusus organisasi, kita pakai form custom dan img
            'organisasi': ['title', 'img', 'organisasi-custom'], 
            // 'link_eksternal' atau jenis lain
            'link_eksternal': ['title', 'link'],
            'teks_biasa': ['title', 'content'], 
        };

        function toggleFields() {
            const selectedType = jenisKontenSelect.value;
            const requiredFields = fieldMap[selectedType] || [];

            allToggleFields.forEach(fieldGroup => {
                // Ambil nama field dari ID form group (misal: 'form-group-title' -> 'title')
                const fieldName = fieldGroup.id.replace('form-group-', '');
                
                // Cek apakah field ini harusnya ditampilkan
                if (requiredFields.includes(fieldName)) {
                    // Tampilkan field group
                    fieldGroup.style.display = 'block';
                    // Hapus atribut 'disabled' dari input/textarea di dalamnya
                    fieldGroup.querySelectorAll('input, textarea, select').forEach(input => {
                        input.removeAttribute('disabled');
                    });
                } else {
                    // Sembunyikan field group
                    fieldGroup.style.display = 'none';
                    // Tambahkan atribut 'disabled' agar data field tersembunyi tidak ikut terkirim saat submit
                    fieldGroup.querySelectorAll('input, textarea, select').forEach(input => {
                        input.setAttribute('disabled', 'disabled');
                    });
                }
            });
            
            // Logika Kebutuhan Required berdasarkan jenis konten
            // Kita atur ulang atribut 'required' untuk Judul dan Konten
            const titleInput = document.getElementById('title');
            const contentTextarea = document.getElementById('content');
            const jabatanInput = document.getElementById('jabatan');
            const deskripsiTextarea = document.getElementById('deskripsi_organisasi');

            // Set Title required HANYA jika bukan null
            if (requiredFields.includes('title')) {
                titleInput.setAttribute('required', 'required');
            } else {
                titleInput.removeAttribute('required');
            }

            // Set Content/Jabatan/Deskripsi required jika dibutuhkan
            contentTextarea.removeAttribute('required');
            jabatanInput.removeAttribute('required');
            deskripsiTextarea.removeAttribute('required');

            if (selectedType === 'berita' || selectedType === 'event' || selectedType === 'teks_biasa') {
                // Berita/Event/Teks biasa butuh content
                contentTextarea.setAttribute('required', 'required');
            } else if (selectedType === 'organisasi') {
                // Organisasi butuh Jabatan dan Deskripsi
                jabatanInput.setAttribute('required', 'required');
                deskripsiTextarea.setAttribute('required', 'required');
            }
            // Untuk Galeri dan Link Eksternal, content/jabatan/deskripsi tidak required
        }

        // 1. Jalankan saat page dimuat 
        toggleFields(); 
        
        // 2. Jalankan setiap kali Jenis Konten berubah
        jenisKontenSelect.addEventListener('change', toggleFields);
    });
</script>
@endsection