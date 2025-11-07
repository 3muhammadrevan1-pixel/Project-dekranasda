@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="dashboard">
<!-- Header -->
<div class="dashboard-header">
<h2>Dashboard Admin</h2>
<p>Kelola semua data dengan mudah melalui panel ini.</p>
</div>

<!-- Statistik -->
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
    
    {{-- Statistik Berita (Class: purple) --}}
    <div class="stat-card purple">
        <div class="icon"><i class="fas fa-newspaper"></i></div>
        <div class="text">
            <h3>{{ $stats['beritaCount'] ?? 0 }}</h3>
            <p>Berita</p>
        </div>
    </div>
    
    {{-- Statistik Event (Class: orange) --}}
    <div class="stat-card orange">
        <div class="icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="text">
            <h3>{{ $stats['eventCount'] ?? 0 }}</h3>
            <p>Event</p>
        </div>
    </div>

    {{-- Statistik Galeri (Class: gold) --}}
    <div class="stat-card gold">
        <div class="icon"><i class="fas fa-image"></i></div>
        <div class="text">
            <h3>{{ $stats['galeriCount'] ?? 0 }}</h3>
            <p>Galeri</p>
        </div>
    </div>

    {{-- Statistik Menu (Class: maroon) --}}
    <div class="stat-card maroon">
        <div class="icon"><i class="fas fa-box"></i></div>
        <div class="text">
            <h3>{{ $stats['menuCount'] ?? 0 }}</h3>
            <p>Menu</p>
        </div>
    </div>

    {{-- Statistik Organisasi (Class: organisasi / abu-abu) --}}
    <div class="stat-card organisasi">
        <div class="icon"><i class="fas fa-users"></i></div>
        <div class="text">
            <h3>{{ $stats['organisasiCount'] ?? 0 }}</h3>
            <p>Organisasi</p>
        </div>
    </div>

</div>

<!-- Menu Cards -->
<div class="dashboard-cards">
    
    {{-- Card Produk (Class: produk) --}}
    <a href="{{ route('admin.produk.index') }}" class="dashboard-card produk">
        <i class="fas fa-gifts"></i>
        <h3>Produk</h3>
        <p>Daftar lengkap produk</p>
    </a>

    {{-- Card Menu (Class: menu) --}}
    <a href="{{ route('admin.menu.index') }}" class="dashboard-card menu">
        <i class="fas fa-box"></i>
        <h3>menu</h3>
        <p>Kelola menu</p>
    </a>
    
    {{-- Card Berita (Class: berita) --}}
    <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card berita">
        <i class="fas fa-newspaper"></i>
        <h3>berita</h3>
        <p>Artikel & berita terbaru</p>
    </a>
    
    {{-- Card Event (Class: event) --}}
    <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card event">
        <i class="fas fa-calendar-alt"></i>
        <h3>Event</h3>
        <p>Acara & kegiatan mendatang</p>
    </a>
    
    {{-- Card Galeri (Class: galeri) --}}
    <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card galeri">
        <i class="fas fa-image"></i>
        <h3>Galeri</h3>
        <p>Kumpulan foto & dokumentasi</p>
    </a>
    
    {{-- Card Struktur Organisasi (Class: struktur) --}}
    <a href="{{ route('admin.menu_data.index') }}?jenis_konten=organisasi" class="dashboard-card struktur">
        <i class="fas fa-users"></i>
        <h3>Struktur</h3>
        <p>Struktur organisasi lengkap</p>
    </a>
    
    {{-- Card Toko (Class: toko) --}}
    <a href="{{ route('admin.toko.index') }}" class="dashboard-card toko">
        <i class="fas fa-store"></i>
        <h3>Toko</h3>
        <p>Daftar toko & produk terkait</p>
    </a>

</div>


</div>
@endsection