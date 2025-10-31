@extends('layouts.app')

{{-- Menggunakan kolom 'title' untuk judul halaman --}}
@section('title', $berita->title . ' - Dekranasda Kota Bogor')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 container-berita bg-white p-4 rounded shadow-sm">
            {{-- Mengakses kolom 'title' --}}
            <h1>{{ $berita->title }}</h1>

            <div class="info-bar d-flex flex-wrap gap-3 text-muted mb-3">
                {{-- FIX: Memformat kolom 'date' dari TbMenuData --}}
                <div><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($berita->date)->format('d F Y') }}</div>
                
                {{-- Mengakses kolom 'location' (Tambahkan fallback jika null) --}}
                <div><i class="bi bi-geo-alt"></i> {{ $berita->location ?? 'Online' }}</div>
                
                {{-- FIX: Kolom 'category' diganti dengan nama Menu dari relasi 'menu()' --}}
                {{-- Ini mengasumsikan relasi menu() sudah ada di TbMenuData.php --}}
                <div><i class=""></i> {{ $berita->menu->nama ?? 'Berita' }}</div> 
            </div>

            {{-- Mengakses kolom 'img' --}}
            <img src="{{ asset('storage/'.$berita->img) }}" alt="{{ $berita->title }}" class="main-img shadow-sm mb-3">

            {{-- Mengakses kolom 'content' --}}
            <div class="mb-4">{!! $berita->content !!}</div>

            <a href="{{ route('home') }}#berita" class="btn btn-custom">
                <i class="bi bi-arrow-left"></i> Kembali ke Berita
            </a>
        </div>
    </div>
</div>
@endsection
