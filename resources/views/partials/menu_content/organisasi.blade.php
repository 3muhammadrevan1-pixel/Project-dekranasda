@extends('layouts.app')

@section('title', 'Struktur Organisasi - Dekranasda Kota Bogor')

{{-- 
    Pastikan Anda memuat CSS ini di layout utama (layouts.app) 
    atau di sini jika ingin style khusus halaman organisasi.
    Contoh:
    <link rel="stylesheet" href="{{ asset('resources/css/organisasi.css') }}">
--}}

@section('content')
<div class="container py-5">
    <h2 class="section-title">Struktur</h2>

    {{-- Ambil data organisasi dari $menu_data yang dikirim dari controller --}}
    @php
        // $organisasi diasumsikan adalah koleksi dari TbMenuData
        $organisasi = $menu_data ?? collect([]); 
    @endphp

    @if($organisasi->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Struktur organisasi belum diisi.
        </div>
    @else
        <div class="row justify-content-center g-4">
            @foreach ($organisasi as $s)
                @php
                    // Decode konten JSON. Pastikan kolom 'content' sudah di-cast ke array/json di model TbMenuData.
                    // Jika belum di-cast, json_decode diperlukan.
                    // Format di controller: $data['content'] = json_encode([['jabatan' => ..., 'deskripsi' => ...]])
                    $orgData = is_array($s->content) ? $s->content : json_decode($s->content, true);
                    
                    // Ambil item pertama dari array (karena format controller menyimpan array 1 item)
                    $data = $orgData[0] ?? ['jabatan' => 'Jabatan tidak tersedia', 'deskripsi' => 'Deskripsi tidak tersedia'];

                    // FIX GAMBAR: Menggunakan asset('storage/') untuk path relatif yang disimpan di storage/app/public
                    $imagePath = 'https://placehold.co/150x150/e6d3c6/5c4033?text=Foto';

                    if ($s->img) {
                        if (\Illuminate\Support\Str::startsWith($s->img, ['http://', 'https://'])) {
                            // Path adalah URL eksternal
                            $imagePath = $s->img;
                        } else {
                            // Path adalah path relatif (dari controller) yang mengarah ke storage/app/public
                            $imagePath = asset('storage/' . $s->img);
                        }
                    }
                @endphp

                <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
                    <div class="card h-100 text-center p-4" style="max-width:320px; border-radius:16px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                        
                        {{-- Foto Anggota --}}
                        
                        <img 
                            src="{{ $imagePath }}" 
                            class="struktur-img mx-auto mb-3 rounded-circle" 
                            alt="{{ $s->title }}"
                            style="width:150px; height:150px; object-fit:cover; border:4px solid #f5e6dc;"
                            onerror="this.onerror=null; this.src='https://placehold.co/150x150/e6d3c6/5c4033?text=Foto';"
                        >
                        
                        {{-- Nama Anggota (dari kolom title) --}}
                        <h5 class="card-title mt-2 mb-1" style="font-weight:600;">{{ $s->title }}</h5>
                        
                        {{-- Jabatan (dari JSON content) --}}
                        <p class="text-muted mb-2" style="font-size:0.95rem;">
                            {{ $data['jabatan'] ?? 'Jabatan tidak tersedia' }}
                        </p>

                        {{-- Deskripsi/Keterangan (dari JSON content) --}}
                        <p class="struktur-desc" style="font-size:0.9rem; color:#555;">
                            {{ $data['deskripsi'] ?? 'Deskripsi tidak tersedia' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection