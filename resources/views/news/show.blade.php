@extends('layouts.app')

@section('title', 'Beranda - Dekranasda Kota Bogor')

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10 container-berita bg-white p-4 rounded shadow-sm">
      <h1>{{ $berita->title }}</h1>s

      <div class="info-bar d-flex flex-wrap gap-3 text-muted mb-3">
        <div><i class="bi bi-calendar-event"></i> {{ $berita->date }}</div>
        <div><i class="bi bi-geo-alt"></i> {{ $berita->location }}</div>
        <div><i class=""></i> {{ $berita->category }}</div>
      </div>

      <img src="{{ asset('storage/'.$berita->img) }}" alt="{{ $berita->title }}" class="main-img shadow-sm mb-3">

      <div class="mb-4">{!! $berita->content !!}</div>

      <a href="{{ route('home') }}#berita" class="btn btn-custom">
        <i class="bi bi-arrow-left"></i> Kembali ke Berita
      </a>
    </div>
  </div>
</div>
