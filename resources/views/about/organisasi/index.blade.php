@extends('layouts.app')

@section('title', 'Struktur Organisasi - Dekranasda Kota Bogor')

@section('content')
<div class="container py-5">
  <h2 class="section-title">Struktur Organisasi</h2>
  <p class="mb-4">
    Dekranasda Kota Bogor periode <strong>2025–2030</strong> memiliki struktur organisasi yang solid untuk 
    mendukung pengembangan UMKM kerajinan lokal. Berikut susunan kepengurusan inti:
  </p>

  <div class="row justify-content-center g-4">
    @foreach ($organisasi as $s)
      <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
        <div class="card h-100 text-center p-4" style="max-width:320px;">
          <img src="{{ asset('storage/' . $s->img) }}" 
               class="struktur-img mx-auto mb-3" 
               alt="{{ $s->nama }}">
          <h5 class="card-title">{{ $s->nama }}</h5>
          <p class="text-muted mb-2">{{ $s->jabatan }}</p>
          <p class="struktur-desc">{{ $s->deskripsi }}</p>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Keterangan tambahan -->
  <div class="mt-5 text-center">
    <p>
      Berdasarkan pelantikan pada <strong>28 Agustus 2025</strong>, Dekranasda Kota Bogor periode 2025–2030 resmi dikukuhkan. 
      Ketua Umum <strong>Yantie Rachim</strong> menekankan pentingnya kebersamaan dalam mengangkat produk kerajinan Kota Bogor agar mampu bersaing hingga tingkat internasional.
    </p>
    <p>
      Sementara itu, <strong>Ketua Harian Rahmat Hidayat</strong> menyampaikan sejumlah program prioritas, termasuk pengembangan UMKM berbasis teknologi digital, inovasi pendanaan, hingga rencana pameran di luar negeri pada tahun 2026.
    </p>
  </div>
</div>
@endsection
