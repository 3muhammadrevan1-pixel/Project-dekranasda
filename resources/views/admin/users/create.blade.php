@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')

{{-- Tambahkan styling custom untuk layout 2 kolom dan card form --}}

<style>
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
box-sizing: border-box; /* Penting untuk flex layout */
}
.form-actions {
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
.is-invalid {
border-color: #dc3545;
}
.invalid-feedback {
color: #dc3545;
font-size: 0.875em;
margin-top: 0.25rem;
}

</style>
<div class="content">
<div class="header-actions">
<h2>Tambah Pengguna Baru</h2>
</div>

<div class="form-card">
{{-- Menggunakan route('user.store') yang sudah benar --}}
<form action="{{ route('user.store') }}" method="POST" class="form">
@csrf

    <!-- INFORMASI DASAR PENGGUNA (2 KOLOM) -->
    <div style="margin-bottom: 20px; border-bottom: 1px solid #e0e0e0; padding-bottom: 5px;">
        <h4 style="font-size: 1.1em; color: #333;">Data Diri</h4>
    </div>
    
    <!-- Mulai Layout 2 Kolom untuk Nama dan Email -->
    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        
        <div class="form-group" style="flex: 1; min-width: 0;">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
                placeholder="Masukkan nama lengkap pengguna" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="flex: 1; min-width: 0;">
            <label for="email">Email</label>
            {{-- FIX BUG: Tambahkan autocomplete="off" agar browser tidak mengisi email user yang sedang login --}}
            <input type="email" id="email" name="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email') }}"
                placeholder="Masukkan email unik untuk login" required autocomplete="off">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
    </div>
    <!-- Akhir Layout 2 Kolom untuk Nama dan Email -->
    
    <!-- ROLE (Peran) PENGGUNA & STATUS (2 KOLOM) -->
    <div style="margin-top: 10px; border-bottom: 1px solid #e0e0e0; padding-bottom: 5px;">
        <h4 style="font-size: 1.1em; color: #333;">Pengaturan Akses </h4>
    </div>

    <!-- Mulai Layout 2 Kolom untuk Role dan Status -->
    <div style="display: flex; gap: 20px;">

        <div class="form-group" style="flex: 1; min-width: 0;">
            <label for="role">Role Pengguna</label>
            {{-- Pilihan Role: Hanya Admin dan Operator --}}
            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="">-- Pilih Peran --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="flex: 1; min-width: 0;">
            <label for="status">Status Akun</label>
            {{-- Pilihan Status: Aktif dan Nonaktif --}}
            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">-- Pilih Status --</option>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>
    <!-- Akhir Layout 2 Kolom untuk Role dan Status -->
    
    <!-- PASSWORD AWAL (2 KOLOM) -->
    <div style="margin-top: 30px; border-bottom: 1px solid #e0e0e0; padding-bottom: 5px;">
        <h4 style="font-size: 1.1em; color: #333;">Password Awal</h4>
    </div>
    
    <!-- Mulai Layout 2 Kolom untuk Password -->
    <div style="display: flex; gap: 20px;">

        <div class="form-group" style="flex: 1; min-width: 0;">
            <label for="password">Password</label>
            {{-- FIX BUG: Tambahkan autocomplete="new-password" agar browser tidak mengisi password user yang sedang login --}}
            <input type="password" id="password" name="password" 
                class="form-control @error('password') is-invalid @enderror" 
                placeholder="Masukkan password" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group" style="flex: 1; min-width: 0;">
            <label for="password_confirmation">Konfirmasi Password</label>
            {{-- FIX BUG: Tambahkan autocomplete="new-password" --}}
            <input type="password" id="password_confirmation" name="password_confirmation" 
                class="form-control" 
                placeholder="Ulangi password di atas" required autocomplete="new-password">
        </div>
        
    </div>
    <!-- Akhir Layout 2 Kolom untuk Password -->

    <!-- TOMBOL AKSI -->
    <div class="form-actions">
        <!-- Tombol simpan/store -->
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Pengguna
        </button>
        <!-- Tombol kembali ke halaman daftar pengguna -->
        {{-- FIX: Menggunakan route('user.index') yang sudah benar untuk kembali --}}
        <a href="{{ route('user.index') }}" class="btn btn-secondary">
            Batal / Kembali
        </a>  
    </div>
</form>
</div>
</div>

@endsection