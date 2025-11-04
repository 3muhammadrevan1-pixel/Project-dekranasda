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
<div class="stat-card blue">
    <div class="icon"><i class="fas fa-box"></i></div>
    <div class="text">
        <h3>120</h3>
        <p>Produk</p>
    </div>
</div>
<div class="stat-card green">
    <div class="icon"><i class="fas fa-store"></i></div>
    <div class="text">
        <h3>35</h3>
        <p>Toko</p>
    </div>
</div>
<div class="stat-card purple">
    <div class="icon"><i class="fas fa-newspaper"></i></div>
    <div class="text">
        <h3>18</h3>
        <p>Berita</p>
    </div>
</div>
<div class="stat-card orange">
    <div class="icon"><i class="fas fa-calendar-alt"></i></div>
    <div class="text">
        <h3>6</h3>
        <p>Event</p>
    </div>
</div>


<div class="stat-card gold">
    <div class="icon"><i class="fas fa-image"></i></div>
    <div class="text">
        <h3>42</h3>
        <p>Galeri</p>
    </div>
</div>

<div class="stat-card maroon">
    <div class="icon"><i class="fas fa-box"></i></div>
    <div class="text">
        <h3>7</h3>
        <p>Menu</p>
    </div>
</div>
{{-- 
<div class="stat-card black">
    <div class="icon"><i class="fas fa-box"></i></div>
    <div class="text">
        <h3>8</h3>
        <p>Menu</p>
    </div>
</div> --}}



</div>

<!-- Menu Cards -->
<div class="dashboard-cards">
    {{-- TAMBAHAN: Card untuk Produk, diletakkan di awal agar mudah diakses --}}
    <a href="{{ route('admin.produk.index') }}" class="dashboard-card produk">
        <i class="fas fa-gifts"></i>
        <h3>Produk</h3>
        <p>Daftar lengkap produk</p>
    </a>

    <a href="{{ route('admin.menu.index') }}" class="dashboard-card menu">
        <i class="fas fa-box"></i>
        <h3>menu</h3>
        <p>Kelola menu</p>
    </a>
    <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card berita">
        <i class="fas fa-newspaper"></i>
        <h3>berita</h3>
        <p>Artikel & berita terbarua</p>
    </a>
    <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card event">
        <i class="fas fa-calendar-alt"></i>
        <h3>Event</h3>
        <p>Acara & kegiatan mendatang</p>
    </a>
    <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card galeri">
        <i class="fas fa-image"></i>
        <h3>Galeri</h3>
        <p>Kumpulan foto & dokumentasi</p>
    </a>
    {{-- <a href="{{ route('admin.menu_data.index') }}" class="dashboard-card struktur">
        <i class="fas fa-users"></i>
        <h3>Struktur</h3>
        <p>Struktur organisasi lengkap</p>
    </a> --}}
    <a href="{{ route('admin.toko.index') }}" class="dashboard-card toko">
        <i class="fas fa-store"></i>
        <h3>Toko</h3>
        <p>Daftar toko & produk terkait</p>
    </a>

</div>


</div>
@endsection