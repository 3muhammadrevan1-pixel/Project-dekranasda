@extends('admin.layouts.app')

@section('title', 'Edit Pengguna: ' . $user->name)

@section('content')

<style>
/* ---------------------------------------------------------------- /
/ CSS Kustom (Tidak ada perubahan di sini) /
/ ---------------------------------------------------------------- */
.form-card {
background-color: #fff;
padding: 20px;
border-radius: 8px;
box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.form-group {
margin-bottom: 15px;
}
.form-control {
width: 100%;
padding: 8px 10px;
border: 1px solid #ccc;
border-radius: 4px;
box-sizing: border-box;
transition: border-color 0.2s, box-shadow 0.2s;
}
.is-invalid {
border-color: #dc3545;
}
.invalid-feedback {
color: #dc3545;
font-size: 0.875em;
margin-top: 0.25rem;
}

/* 1. STYLING RESPONSIVE BARU */
.form-grid-2-column {
display: flex;
flex-wrap: wrap;
gap: 20px;
margin-bottom: 10px;
}
.form-grid-2-column .form-group {
flex: 1 1 calc(50% - 10px);
min-width: 250px;
}
@media (max-width: 768px) {
.form-grid-2-column {
flex-direction: column;
gap: 0;
margin-bottom: 0;
}
.form-grid-2-column .form-group {
flex: 1 1 100%;
}
}

/* 2. STYLING HEADER BARU */
.form-section-header {
margin-top: 30px;
margin-bottom: 15px;
}
.form-section-header h4 {
font-size: 1.2em;
color: #2c3e50;
margin-bottom: 5px;
}
.form-section-header hr {
border: 0;
height: 1px;
background-color: #dcdde1;
margin-top: 5px;
}

/* 3. STYLING TOMBOL */
.form-buttons {
margin-top: 30px;
padding-top: 15px;
border-top: 1px solid #e0e0e0;
text-align: right;
}
.btn {
padding: 8px 15px;
border-radius: 4px;
cursor: pointer;
text-decoration: none;
display: inline-block;
margin-left: 10px;
}
.btn-primary {
background-color: #007bff;
color: white;
border: none;
}
.btn-secondary {
background-color: #6c757d;
color: white;
border: none;
}

/* 4. PENAMBAHAN STYLING ORANYE & WAJIB ISI /
.form-control:focus {
border-color: #ff8c00; / Warna border oranye saat fokus /
box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25); / Glow oranye saat fokus */
outline: none;
}
.required-indicator {
color: #dc3545;
font-weight: bold;
margin-left: 4px;
}
</style>

<div class="content">
<div class="header-actions">
{{-- Menggunakan variabel $user yang dilempar dari Controller --}}
<h2>Edit Pengguna: {{ $user->name }}</h2>
</div>

<div class="form-card">
    {{-- Rute form diarahkan ke user.update dengan ID pengguna --}}
    <form action="{{ route('user.update', $user->id) }}" method="POST" class="form">
        @csrf
        @method('PUT') 

        <!-- SEKSI: INFORMASI DASAR PENGGUNA -->
        <div class="form-section-header" style="margin-top: 0;">
            <h4>Informasi Dasar</h4>
            <hr>
        </div>
        
        <div class="form-grid-2-column">
            <div class="form-group">
                <label for="name">Nama Lengkap<span class="required-indicator">*</span></label>
                <input type="text" id="name" name="name" 
                    class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name', $user->name) }}" 
                    placeholder="Masukkan nama lengkap pengguna" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email<span class="required-indicator">*</span></label>
                <input type="email" id="email" name="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email', $user->email) }}" 
                    placeholder="Masukkan email unik untuk login" required autocomplete="off">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- SEKSI: PENGATURAN AKSES DAN PERAN -->
        <div class="form-section-header">
            <h4>Pengaturan Akses dan Status</h4>
            <hr>
        </div>
        
        <!-- ROLE & STATUS AKUN (Dibuat 2 kolom) -->
        <div class="form-grid-2-column">
            
            <!-- ROLE (Peran) PENGGUNA - HANYA ADMIN & OPERATOR -->
            <div class="form-group">
                <label for="role">Role<span class="required-indicator">*</span></label>
                <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Peran --</option>
                    
                    {{-- Logika untuk role yang dipilih saat ini. Hanya Admin dan Operator --}}
                    @php $currentRole = old('role', $user->role ?? 'operator'); @endphp
                    
                    <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="operator" {{ $currentRole == 'operator' ? 'selected' : '' }}>Operator</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- FIELD: STATUS AKUN BARU DITAMBAHKAN -->
            <div class="form-group">
                <label for="status">Status Akun<span class="required-indicator">*</span></label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    
                    {{-- Logika untuk status yang dipilih saat ini. Asumsi kolom status ada --}}
                    @php $currentStatus = old('status', $user->status ?? 'aktif'); @endphp
                    
                    <option value="aktif" {{ $currentStatus == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $currentStatus == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <!-- SEKSI: PENGGANTIAN PASSWORD BARU -->
        <div class="form-section-header">
            <h4>Password Reset (Untuk Admin)</h4>
            <hr>
        </div>
        
        <p style="font-size: 0.9em; color: #6c757d; margin-bottom: 15px;">
            Kosongkan kedua field di bawah jika Anda tidak ingin melakukan perubahan password.
        </p>
        
        <!-- PASSWORD BARU & KONFIRMASI (2 kolom) -->
        <div class="form-grid-2-column">
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="Masukan passwordw" autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                    class="form-control" 
                    placeholder="Ulangi password baru" autocomplete="new-password">
            </div>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="form-buttons">
            <!-- Tombol simpan/update -->
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Pengguna
            </button>
            <!-- Tombol kembali ke halaman daftar pengguna -->
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                Batal / Kembali
            </a>
        </div>
    </form>
</div>


</div>
@endsection