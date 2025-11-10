@extends('layouts.app')

{{-- Judul halaman --}}
@section('title', $berita->title . ' - Dekranasda Kota Bogor')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 container-berita bg-white p-4 rounded shadow-sm">

            {{-- Judul Berita --}}
            <h1 class="mb-3">{{ $berita->title }}</h1>

            {{-- Info Bar --}}
            <div class="info-bar d-flex flex-wrap gap-3 text-muted mb-3">
                {{-- Tanggal --}}
                <div>
                    <i class="bi bi-calendar-event"></i>
                    {{ \Carbon\Carbon::parse($berita->date)->format('d F Y') }}
                </div>

                {{-- Lokasi --}}
                <div>
                    <i class="bi bi-geo-alt"></i>
                    {{ $berita->location ?? 'Online' }}
                </div>

                {{-- Kategori / Menu --}}
                <div>
                    <i class="bi bi-tags"></i>
                    {{ $berita->menu->nama ?? 'Berita' }}
                </div>
            </div>

            {{-- Gambar Utama --}}
            @if($berita->img)
                <img src="{{ asset('storage/'.$berita->img) }}" alt="{{ $berita->title }}" class="main-img shadow-sm mb-3 rounded">
            @endif

            {{-- Konten Berita --}}
            <div class="mb-4">
                {!! $berita->content !!}
            </div>

            {{-- Tombol Kembali ke Berita (selalu ke halaman publik) --}}
            <a href="{{ url('/') }}#berita" class="btn btn-custom">
                <i class="bi bi-arrow-left"></i> Kembali ke Berita
            </a>

        </div>
    </div>
</div>
@endsection
