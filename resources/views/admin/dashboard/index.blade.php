@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="dashboard">
    <div class="dashboard-header">
        <h2>Dashboard Admin</h2>
        <p>Kelola semua data dengan mudah melalui panel ini.</p>
    </div>

    <div class="stats">
        {{-- Statistik Produk (Class: blue) --}}
        <div class="stat-card blue">
            <div class="icon"><i class="fas fa-box"></i></div>
            <div class="text">
                <h3>{{ $stats['productCount'] ?? 0 }}</h3>
                <p>Produk</p>
            </div>
        </div>
        
        {{-- Statistik Toko (Class: green) --}}
        <div class="stat-card green">
            <div class="icon"><i class="fas fa-store"></i></div>
            <div class="text">
                <h3>{{ $stats['storeCount'] ?? 0 }}</h3>
                <p>Toko</p>
            </div>
        </div>
        
        {{-- Statistik Menu Utama (Class: maroon) --}}
        <div class="stat-card maroon">
            <div class="icon"><i class="fas fa-bars"></i></div>
            <div class="text">
                <h3>{{ $stats['menuCount'] ?? 0 }}</h3>
                <p>Menu Utama</p>
            </div>
        </div>

        {{-- Statistik Berita (dinamis) (Class: purple) --}}
        <div class="stat-card purple">
            <div class="icon"><i class="fas fa-newspaper"></i></div>
            <div class="text">
                <h3>{{ $stats['beritaCount'] ?? 0 }}</h3>
                <p>Konten Dinamis</p>
            </div>
        </div>
        
        {{-- Statistik Event (dinamis/statis) (Class: orange) --}}
        <div class="stat-card orange">
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="text">
                <h3>{{ $stats['eventCount'] ?? 0 }}</h3>
                <p>Konten Statis</p>
            </div>
        </div>
        
        {{-- Statistik Galeri (media) (Class: gold) --}}
        <div class="stat-card gold">
            <div class="icon"><i class="fas fa-image"></i></div>
            <div class="text">
                <h3>{{ $stats['galeriCount'] ?? 0 }}</h3>
                <p>Konten Media</p>
            </div>
        </div>

        {{-- Statistik Organisasi (organisasi) (Class: organisasi / abu-abu) --}}
        <div class="stat-card organisasi">
            <div class="icon"><i class="fas fa-users"></i></div>
            <div class="text">
                <h3>{{ $stats['organisasiCount'] ?? 0 }}</h3>
                <p>Konten Organisasi</p>
            </div>
        </div>

        {{-- Statistik User (Ditambahkan: Menggunakan data 'userCount' yang baru) --}}
        <div class="stat-card user">
            <div class="icon"><i class="fas fa-user-circle"></i></div>
            <div class="text">
                <h3>{{ $stats['userCount'] ?? 0 }}</h3>
                <p>User Sistem</p>
            </div>
        </div>

    </div>

    <div class="dashboard-cards">
        
        {{-- Card Produk (Class: produk) --}}
        <a href="{{ route('admin.produk.index') }}" class="dashboard-card produk">
            <i class="fas fa-gifts"></i>
            <h3>Produk</h3>
            <p>Daftar lengkap produk</p>
        </a>

        {{-- Card Menu (Class: menu) --}}
        <a href="{{ route('admin.menu.index') }}" class="dashboard-card menu">
            <i class="fas fa-bars"></i>
            <h3>Menu Utama</h3>
            <p>Kelola struktur menu</p>
        </a>
        
        {{-- Card Berita (dinamis) --}}
        <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card berita">
            <i class="fas fa-newspaper"></i>
            <h3>Dinamis</h3>
            <p>Acara dan Berita</p>
        </a>
        
        {{-- Card Event (dinamis) --}}
        <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card event">
            <i class="fas fa-calendar-alt"></i>
            <h3>Statis</h3>
            <p>informasi dekranasda</p>
        </a>
        
        {{-- Card Galeri (media) --}}
        <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card galeri">
            <i class="fas fa-image"></i>
            <h3>Media</h3>
            <p>Kumpulan foto & dokumentasi</p>
        </a>
        
        {{-- Card Struktur Organisasi (organisasi) --}}
        <a href="{{ route('admin.menu_data.index') }}?jenis_konten=organisasi" class="dashboard-card struktur">
            <i class="fas fa-users"></i>
            <h3>Struktur Organisasi</h3>
            <p>Struktur organisasi lengkap</p>
        </a>
        
        {{-- Card Toko (Class: toko) --}}
        <a href="{{ route('admin.toko.index') }}" class="dashboard-card toko">
            <i class="fas fa-store"></i>
            <h3>Toko</h3>
            <p>Daftar toko & produk terkait</p>
        </a>

        {{-- Card User (Ditambahkan: Pastikan route sudah benar) --}}
        <a href="{{ route('user.index') }}" class="dashboard-card user">
            <i class="fas fa-user-circle"></i>
            <h3>User</h3>
            <p>Manajemen Akun Sistem</p>
        </a>

    </div>


</div>
@endsection