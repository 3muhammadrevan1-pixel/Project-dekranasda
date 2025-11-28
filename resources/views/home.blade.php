@extends('layouts.app')

@section('title', 'Beranda - Dekranasda Kota Bogor')

@section('content')
<!-- Header -->
<header>
    <div class="content">
        <h1>Dekranasda Kota Bogor</h1>
        <p>Mendukung & Mengembangkan Kerajinan Lokal</p>
        <a href="{{ url('/produk') }}" class="btn btn-custom mt-3">Lihat Produk</a>
    </div>
</header>
<!-- Tentang -->
<section id="tentang" class="py-5" style="background:#fffaf6;">
    <div class="container">
        <div class="row align-items-center g-5">
            
            <!-- Foto -->
            <div class="col-lg-6 col-md-12 text-center text-lg-start">
                <!-- Pastikan asset('assets/visi.png') berada di public/assets/visi.png -->
                <img src="{{ asset('assets/visi.png') }}" alt="Dekranasda Kota Bogor" 
                    class="img-fluid rounded-4 shadow-sm" style="max-width:100%;">
            </div>
            
            <!-- Teks + Card -->
            <div class="col-lg-6 col-md-12">
                <h2 class="fw-bold text-brown mb-3">Tentang Dekranasda Kota Bogor</h2>
                <p class="mb-4 text-secondary">
                    Dekranasda (Dewan Kerajinan Nasional Daerah) Kota Bogor merupakan wadah pembinaan dan pengembangan 
                    kerajinan daerah untuk meningkatkan daya saing, memperluas pemasaran, serta menjaga kelestarian budaya 
                    dan kearifan lokal melalui pemberdayaan pengrajin lokal.
                </p>

                <!-- Visi Misi Fokus -->
                <div class="row g-3 mt-4">
                    <div class="col-md-4 d-flex">
                        <div class="info-card text-center flex-fill bg-white p-4 rounded-4 shadow-sm">
                            <i class="bi bi-eye-fill icon text-brown fs-3"></i>
                            <h6 class="fw-bold mt-3">{{ $visi['title'] ?? 'Visi' }}</h6>
                            <p class="mb-0 small text-muted">{{ $visi['text'] ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex">
                        <div class="info-card text-center flex-fill bg-white p-4 rounded-4 shadow-sm">
                            <i class="bi bi-bullseye icon text-brown fs-3"></i>
                            <h6 class="fw-bold mt-3">{{ $misi['title'] ?? 'Misi' }}</h6>
                            <p class="mb-0 small text-muted">{{ $misi['text'] ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex">
                        <div class="info-card text-center flex-fill bg-white p-4 rounded-4 shadow-sm">
                            <i class="bi bi-box-seam icon text-brown fs-3"></i>
                            <h6 class="fw-bold mt-3">{{ $fokus['title'] ?? 'Fokus' }}</h6>
                            <p class="mb-0 small text-muted">{{ $fokus['text'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
</section>

<!-- Program Kerja -->
<section id="program-kerja" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Program Kerja 2025</h2>
        <div class="accordion" id="accordionProgramKerja">
            @foreach ($programKerja as $index => $bidang)
                <div class="accordion-item shadow-lg mb-4 border-0 rounded-4 overflow-hidden">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}"
                            aria-expanded="false"
                            aria-controls="collapse{{ $index }}">
                            <i class="bi bi-diagram-3-fill me-2 text-brown"></i>
                            {{ $bidang['bidang'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $index }}"
                        data-bs-parent="#accordionProgramKerja">
                        <div class="accordion-body bg-white">
                            <div class="row g-4">
                                @foreach ($bidang['program'] as $prog)
                                    <div class="col-md-6">
                                        <div class="p-4 bg-light rounded-4 shadow-sm h-100 border-start border-4 border-brown">
                                            <h6 class="fw-bolder text-dark mb-2">
                                                <i class="bi bi-patch-check-fill text-success me-2"></i>
                                                {{ $prog['judul'] }}
                                            </h6>
                                            <p class="mb-0 small text-muted">{{ $prog['deskripsi'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="container py-5 position-relative">
    <h2 class="section-title mb-4 text-center">Produk Unggulan</h2>

    <button class="scroll-btn left" onclick="scrollProduk(-1)">&#10094;</button>
    <button class="scroll-btn right" onclick="scrollProduk(1)">&#10095;</button>

    <div class="produk-wrapper d-flex overflow-auto" id="produkContainer">
        @foreach ($topProducts as $pr)
            @php
                $firstVariant = $pr->variants->first();

                $rawProductImgPath = $pr->img ?? optional($firstVariant)->img;
                $productImgUrl = $rawProductImgPath ? asset('storage/' . $rawProductImgPath) : asset('assets/default.jpg');
                
                $productPrice = $pr->price ?? optional($firstVariant)->price ?? 0;
                $availableSizes = optional($firstVariant)->sizes ?? [];
                $availableSizes = array_filter($availableSizes);
            @endphp

            <div class="product-card flex-shrink-0 me-3">
                <div class="card h-100 text-center">
                    <img src="{{ $productImgUrl }}" class="card-img-top" alt="{{ $pr->name }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $pr->name }}</h6>
                        <p class="fw-bold harga-produk">Rp {{ number_format($productPrice, 0, ',', '.') }}</p>
                        {{-- Jumlah dilihat --}}
                        <small class="text-muted d-block mb-2" id="clickCount{{ $pr->id }}">
                            Dilihat: {{ $pr->click_count ?? 0 }} kali
                        </small>
                        <button class="btn btn-custom w-100" data-bs-toggle="modal" data-bs-target="#productModal{{ $pr->id }}">
                            Detail
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="productModal{{ $pr->id }}" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content p-0 border-0 rounded-3 shadow-lg overflow-hidden position-relative">
                        <div class="row g-0">
                            <div class="col-md-6 bg-light d-flex flex-column align-items-center justify-content-center p-4">
                                <img id="mainImg{{ $pr->id }}" src="{{ $productImgUrl }}" alt="{{ $pr->name }}" class="img-fluid">
                            </div>
                            <div class="col-md-6 p-4 d-flex flex-column">
                                <div class="modal-body-scroll">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h4 class="modal-title">{{ $pr->name }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <h5 class="text-danger fw-bold mb-3" id="price{{ $pr->id }}">
                                        Rp {{ number_format($productPrice, 0, ',', '.') }}
                                    </h5>
                                    <small class="text-muted mb-3 d-block" id="modalClickCount{{ $pr->id }}">
                                        Dilihat: {{ $pr->click_count ?? 0 }} kali
                                    </small>

                                    
                                    
                                    @if($pr->store)
                                        <div class="mb-3 p-2 bg-light rounded">
                                            <p class="mb-1"><strong>Toko:</strong> {{ $pr->store->name }}</p>
                                            <p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $pr->store->alamat }}</p>
                                        </div>
                                    @endif

                                    @if($pr->variants->count())
                                        <div class="mb-3">
                                            <label class="fw-semibold mb-2 d-block">Pilih Warna:</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($pr->variants as $variant)
                                                    @php
                                                        $variantImg = $variant->img ? asset('storage/' . $variant->img) : $productImgUrl;
                                                    @endphp
                                                    <button type="button"
                                                            class="btn btn-outline-dark btn-sm color-btn {{ $loop->first ? 'active' : '' }}"
                                                            data-product="{{ $pr->id }}"
                                                            data-color="{{ $variant->color }}"
                                                            data-img="{{ $variantImg }}"
                                                            data-price="{{ $variant->price ?? $productPrice }}">
                                                        {{ ucfirst($variant->color) }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>

                                        @if(!empty($availableSizes))
                                            <div class="mb-3 size-wrapper" id="sizeWrapper{{ $pr->id }}">
                                                <label class="fw-semibold mb-2 d-block">Pilih Ukuran:</label>
                                                <div class="d-flex flex-wrap gap-2" id="sizes{{ $pr->id }}">
                                                    @foreach($availableSizes as $s)
                                                        <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm size-option"
                                                                    onclick="selectSize({{ $pr->id }}, '{{ $s }}')">
                                                            {{ $s }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="mb-3">
                                        <label class="fw-semibold mb-2 d-block">Jumlah:</label>
                                        <input type="number" class="form-control w-50" value="1" min="1" id="qty{{ $pr->id }}">
                                    </div>

                                    <a href="#"
                                        class="btn btn-wa w-100 mt-auto d-flex justify-content-center align-items-center gap-2 fw-semibold"
                                        data-wa="{{ $pr->store->telepon ?? '6280000000000' }}"
                                        data-store-name="{{ $pr->store->name ?? '' }}"
                                        data-store-address="{{ $pr->store->alamat ?? '' }}"
                                        onclick="sendWA({{ $pr->id }})">
                                        <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
                                    </a>

                                    {{-- START: PERUBAHAN TAMPILAN DESKRIPSI KE COLLAPSIBLE --}}
                                    <div class="mt-4">
                                        <p class="collapse-text-header collapsed"
                                       data-bs-target="#collapseDesc{{ $pr->id }}" 
                                        aria-expanded="false" 
                                        aria-controls="collapseDesc{{ $pr->id }}"
                                        role="button">
                                            Deskripsi Produk
                                            <i class="bi bi-chevron-down icon"></i>
                                        </p>

                                        <div class="collapse" id="collapseDesc{{ $pr->id }}">
                                            <div class="product-desc mt-0">
                                                {!! nl2br(e($pr->desc ?? 'Deskripsi tidak tersedia')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Modal Konfirmasi WA -->
<div class="modal fade" id="waConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title">Konfirmasi Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="waConfirmMessage" class="mb-0">Apakah Anda yakin ingin memesan produk ini?</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success rounded-pill" id="waConfirmBtn">
                    <i class="bi bi-whatsapp me-1"></i> Pesan
                </button>
            </div>
        </div>
    </div>
</div>

 <!-- Tombol Lihat Semua Produk -->
    <div class="text-center mt-4">
        <a href="{{ url('/produk') }}" class="btn btn-custom px-4 py-2 fw-semibold">
            Lihat Semua Produk
        </a>
    </div>
@php
use Illuminate\Support\Str;
use Carbon\Carbon;

// Memastikan variabel $news tersedia (sesuai HomeController)
$items = $news ?? collect([]); 
$menuName = 'Berita Terkini'; 
@endphp

<section id="berita" class="container py-5">
    <h2 class="section-title text-center mb-5" style="color: #5c4033; font-weight: 700;">{{ $menuName }}</h2>

    @if($items->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Saat ini belum ada berita tersedia.
        </div>
    @else
        {{-- Pembungkus utama untuk swipe horizontal (Menggunakan class content-wrapper) --}}
        <div class="content-wrapper">
            {{-- Loop menggunakan variabel $news --}}
            @foreach ($items as $item)
                @php
                    $imagePath = $item->img 
                        ? asset('storage/' . $item->img) 
                        : 'https://placehold.co/400x250/f5e6dc/5c4033?text=Tidak+Ada+Gambar';
                    
                    // Escape full content untuk data attribute
                    $fullContent = htmlspecialchars($item->content, ENT_QUOTES, 'UTF-8');
                @endphp
                
                {{-- Menggunakan class dinamis-card untuk swipe/scroll snap --}}
                <div class="dinamis-card"> 
                    <div class="card h-100 shadow-lg border-0 hover-lift" style="border-radius: 12px; overflow: hidden; transition: transform 0.3s;">
                        
                        {{-- Gambar konten --}}
                        <div class="image-container">
                            <img 
                                src="{{ $imagePath }}" 
                                class="card-img-top" 
                                alt="{{ $item->title }}"
                                onerror="this.onerror=null; this.src='https://placehold.co/400x250/f5e6dc/5c4033?text=Gagal+Memuat';"
                            >
                        </div>
                        
                        <div class="card-body d-flex flex-column p-4">
                            
                            {{-- Meta Info --}}
                            <small class="text-muted mb-2 d-flex align-items-center card-meta" style="font-size: 0.85rem;">
                                <i class="bi bi-calendar-event me-1" style="color: #a1866f;"></i>
                                {{ Carbon::parse($item->date)->format('d F Y') }}
                                <span class="badge detail-badge ms-2">Berita</span>
                            </small>

                            {{-- Judul konten --}}
                            <h5 class="card-title fw-bold" style="color: #3e2f23; font-size: 1.15rem; line-height: 1.4;">{{ $item->title }}</h5>
                            
                            {{-- Cuplikan isi konten --}}
                            <p class="card-text flex-grow-1 mt-2" style="font-size: 0.95rem; color: #555;">
                                {{ Str::limit(strip_tags($item->content), 100) }}
                            </p>
                            
                            {{-- Tombol Aksi (MODE DETAIL - Trigger Modal) --}}
                            <button 
                                type="button" 
                                class="btn btn-custom-sm mt-3 detail-btn"
                                data-bs-toggle="modal" 
                                data-bs-target="#beritaDetailModal" {{-- ID Modal diubah --}}
                                data-title="{{ $item->title }}"
                                data-date="{{ Carbon::parse($item->date)->format('d F Y') }}"
                                data-location="{{ $item->location ?? 'Tidak Ada Lokasi' }}" 
                                data-menu="{{ $menuName }}"
                                data-img="{{ $imagePath }}"
                                data-content="{{ $fullContent }}"
                            >
                                Baca Selengkapnya <i class="bi bi-arrow-right-short"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

{{-- ================================================================= --}}
{{-- MODAL UNTUK TAMPILAN DETAIL BERITA --}}
{{-- ================================================================= --}}

<div class="modal fade" id="beritaDetailModal" tabindex="-1" aria-labelledby="beritaDetailModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: 16px;">
        <div class="modal-header border-0 pb-0" style="padding: 20px 25px 0;">
            <h5 class="modal-title fw-bold" id="beritaDetailModalLabel" style="color: #3e2f23;">Detail Berita</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5">
            <div class="container-konten-modal">

                {{-- Judul Konten --}}
                <h1 id="modal-title" class="fw-bold" style="font-size: 2rem; color: #5c4033; margin-bottom: 15px;"></h1>

                {{-- Info Bar --}}
                <div class="info-bar mb-4 d-flex flex-wrap gap-3">
                    <div id="modal-date" class="d-flex align-items-center">
                        <i class="bi bi-calendar-event me-2"></i> <span></span>
                    </div>
                    <div id="modal-location" class="d-flex align-items-center">
                        <i class="bi bi-geo-alt me-2"></i> <span></span>
                    </div>
                    <div id="modal-menu" class="d-flex align-items-center">
                        <i class="bi bi-tags me-2"></i> <span></span>
                    </div>
                </div>

                <hr class="separator my-4">

                {{-- Gambar Utama --}}
                <img id="modal-img" src="" alt="" class="main-img shadow-sm mb-4 rounded" style="display: none;">

                {{-- Konten Penuh --}}
                <div id="modal-content" class="content-body" style="line-height: 1.8; color: #3e2f23;">
                    {{-- Isi konten HTML akan dimasukkan di sini --}}
                </div>
            </div>
        </div>
        <div class="modal-footer border-0 pt-0" style="padding: 15px 25px 25px;">
            <button type="button" class="btn btn-custom" data-bs-dismiss="modal">
                <i class="bi bi-arrow-left"></i> Tutup
            </button>
        </div>
    </div>
</div>
</div>
{{-- ================================================================= --}}
{{-- STYLE (Gaya untuk Listing dan Detail) --}}
{{-- ================================================================= --}}

<style>
body {
font-family: "Inter", sans-serif;
color: #3e2f23;
}
.section-title {
color: #5c4033;
font-weight: 700;
font-size: 2.2rem;
}
.card-title {
color: #3e2f23;
font-size: 1.15rem !important;
line-height: 1.4;
}
.link-badge, .detail-badge {
font-size: 0.75rem;
padding: 4px 8px;
border-radius: 10px;
font-weight: 600;
}
.link-badge {
background-color: #5c4033;
color: #fff;
}
.detail-badge {
background-color: #f5e6dc;
color: #a1866f;
border: 1px solid #a1866f;
}

/* Modal Info Bar */
.info-bar {
    font-size: 0.95rem;
    color: #7a6651;
}
.info-bar i {
    color: #a1866f;
    font-size: 1.1em;
}
.main-img {
    width: 100%;
    max-height: 450px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Custom Button Styles */
.btn-custom {
    background-color: #a1866f;
    color: #fff;
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 500;
    transition: background-color 0.3s;
    border: none;
    font-size: 1rem;
}
.btn-custom:hover {
    background-color: #5c4033;
    color: #fff;
}
.btn-custom-sm {
    background-color: #5c4033;
    color: #fff;
    border-radius: 20px;
    padding: 8px 18px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: background-color 0.3s;
    border: none;
}
.btn-custom-sm:hover {
    background-color: #a1866f;
    color: #fff;
}
hr.separator {
    border: 0;
    height: 1px;
    background: #e0d7cd;
    margin: 15px 0;
}

/* KONTEN CARD LISTING (Swipe) */
.content-wrapper {
    display: flex;
    flex-wrap: nowrap;
    gap: 1.5rem;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    padding-bottom: 20px; 
    scroll-snap-type: x mandatory;
}
.content-wrapper::-webkit-scrollbar {
    height: 8px;
}
.content-wrapper::-webkit-scrollbar-thumb {
    background: #a1866f;
    border-radius: 4px;
}

.dinamis-card {
    flex: 0 0 auto;
    width: 300px;
    min-width: 280px;
    scroll-snap-align: start;
}
.dinamis-card .image-container {
    height: 180px;
    overflow: hidden;
}
.dinamis-card .card-img-top {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 0;
    transition: transform 0.5s ease;
}
.dinamis-card:hover .card-img-top {
    transform: scale(1.05);
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
}

/* RESPONSIVE ADJUSTMENTS */
@media (max-width: 992px) {
    .section-title { font-size: 2rem; }
    #modal-title { font-size: 1.8rem !important; }
}

@media (max-width: 768px) {
    .section-title { font-size: 1.7rem; }
    #modal-title { font-size: 1.5rem !important; }
    .info-bar { font-size: 0.85rem; gap: 10px; }
    .btn-custom { padding: 8px 18px; font-size: 0.9rem; }

    .dinamis-card {
        width: 90vw; 
        min-width: 250px;
    }
}

</style>
<!-- Galeri -->
<section id="galeri" class="container py-5">
    <h2 class="section-title">Galeri</h2>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        {{-- Loop menggunakan variabel $galeriTerbaru --}}
        @foreach ($galeriTerbaru as $i => $g)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column">
                    <div style="aspect-ratio: 4/3; overflow: hidden; border-radius:10px;">
                        {{-- FIX: Menggunakan asset('storage/') --}}
                        <img src="{{ asset('storage/' . $g->img) }}" 
                            class="img-fluid gallery-img" 
                            alt="{{ $g->title ?? 'Galeri ' . ($i+1) }}" 
                            data-bs-toggle="modal" data-bs-target="#galeriModal" 
                            data-index="{{ $i }}" 
                            style="width:100%; height:100%; object-fit:cover;">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        {{-- PERBAIKAN: Menggunakan route('page.dynamic') dengan parameter slug --}}
        {{-- Ini akan menghasilkan URL: /halaman/{slug} --}}
        <a href="{{ route('page.dynamic', ['slug' => $galeriSlug]) }}" class="btn btn-custom">
            Lihat Semua Galeri <i class="bi bi-images ms-2"></i>
        </a>
    </div>
</section>

<!-- Modal Galeri Modern -->
<div class="modal fade" id="galeriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content position-relative p-3" 
            style="background-color: #fffaf6; border-radius: 16px; box-shadow: 0 8px 25px rgba(0,0,0,0.2);">

            <!-- Tombol kiri -->
            <button type="button" class="modal-btn position-absolute top-50 start-0" id="prevImg">&#10094;</button>

            <!-- Gambar -->
            <div class="modal-img-container d-flex justify-content-center align-items-center">
                <img id="modalImg" src="" class="img-fluid rounded modal-image">
            </div>

            <!-- Tombol kanan -->
            <button type="button" class="modal-btn position-absolute top-50 end-0" id="nextImg">&#10095;</button>

            <!-- Tombol close -->
            <button type="button" class="modal-close" data-bs-dismiss="modal">&times;</button>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
// Data produk dari controller
const allProducts = @json($allProductsJs);

// === FORMAT HARGA RUPIAH ===
function formatRupiah(angka){
    if(!angka) return "Rp 0";
    // Pastikan angka adalah string sebelum replace
    return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
}

// Fungsi dummy untuk updateWA, disesuaikan dengan sendWA
function updateWa(productId) {
}

// === PILIH SIZE ===
function selectSize(productId, size){
    const sizesContainer = document.getElementById('sizes'+productId);
    if(!sizesContainer) return;
    sizesContainer.querySelectorAll('.size-option').forEach(b=>b.classList.remove('active'));
    // Gunakan trim() untuk menghilangkan spasi jika ada di data
    const btn = Array.from(sizesContainer.querySelectorAll('.size-option')).find(b=>b.innerText.trim()==size.trim());
    if(btn) btn.classList.add('active');
    // PENTING: Panggil updateWa di sini
    updateWa(productId); 
}
// Fungsi WA dengan modal konfirmasi modern
let waLink = '';
function sendWA(productId){
    const pr = allProducts.find(p => p.id == productId);
    if(!pr) return;

    const qty = document.getElementById('qty'+productId)?.value || 1;
    // Ambil info dari tombol yang sedang active
    const selectedColor = document.querySelector('#productModal'+productId+' .color-btn.active')?.innerText || '-';
    const selectedSize = document.querySelector('#sizes'+productId+' .size-option.active')?.innerText || '-';
    const currentPriceText = document.getElementById('price'+productId)?.innerText || 'Harga tidak tersedia';

    const waBtn = document.querySelector('#productModal'+productId+' .btn-wa');
    const waNumber = waBtn.dataset.wa;
    const storeName = waBtn.dataset.storeName || (pr.store?.name || '-');
    const storeAddress = waBtn.dataset.storeAddress || (pr.store?.alamat || '-');

    const message = `Halo Admin, saya ingin memesan:
Produk: ${pr.name}
Harga: ${currentPriceText}
Toko: ${storeName}
Alamat: ${storeAddress}
Warna: ${selectedColor}
Ukuran: ${selectedSize}
Jumlah: ${qty}
Terima kasih.`;

    waLink = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
    document.getElementById('waConfirmMessage').innerText = `Apakah Anda yakin ingin memesan ${pr.name}?`;
    const modal = new bootstrap.Modal(document.getElementById('waConfirmModal'));
    modal.show();
}

// Tombol “Pesan” modal WA
document.getElementById('waConfirmBtn').addEventListener('click', function(){
    if(waLink) window.open(waLink, '_blank');
    bootstrap.Modal.getInstance(document.getElementById('waConfirmModal')).hide();
});

// === PILIH WARNA & UPDATE VARIANT (FIXED: Logika Sederhana) ===
document.addEventListener('click', function(e){
    if(e.target.classList.contains('color-btn')){
        const productId = e.target.dataset.product;
        const color = e.target.dataset.color;
        const product = allProducts.find(p=>p.id==productId);
        if(!product) return;
        // Cari variant yang sesuai
        const variant = product.variants.find(v=>v.color===color);
        // Variant mungkin null jika data variant tidak lengkap, jadi dicek dulu
        if(!variant) {
            console.error("Variant tidak ditemukan untuk warna:", color);
            return; 
        }

        // Update gambar utama
        const mainImg = document.getElementById('mainImg'+productId);
        const newImgSrc = e.target.dataset.img; 
        if(mainImg && newImgSrc) {
            mainImg.src = newImgSrc;
        }

        // Update harga
        const priceEl = document.getElementById('price'+productId);
        // Pastikan price tidak null/undefined sebelum di format
        if(priceEl) priceEl.innerText = formatRupiah(variant.price ?? product.price ?? 0); 

        // Update active button warna
        document.querySelectorAll(`#productModal${productId} .color-btn`).forEach(b=>b.classList.remove('active'));
        e.target.classList.add('active');

        // Update ukuran jika ada
        const sizeWrapper = document.getElementById('sizeWrapper'+productId);
        const sizesContainer = document.getElementById('sizes'+productId);
        
        // Cek data sizes dari JSON yang sudah diexplode di Controller (array JS)
        if(variant.sizes && variant.sizes.length > 0 && variant.sizes[0] !== ""){
            if(sizeWrapper) sizeWrapper.style.display='block';
            if(sizesContainer){
                sizesContainer.innerHTML='';
                variant.sizes.forEach(s=>{
                    const sizeVal = s; 
                    
                    const btn = document.createElement('button');
                    btn.type='button';
                    btn.className='btn btn-outline-secondary btn-sm size-option';
                    btn.innerText=sizeVal;
                    btn.onclick=()=>selectSize(productId,sizeVal);
                    sizesContainer.appendChild(btn);
                });
            }
        } else {
            if(sizeWrapper) sizeWrapper.style.display='none';
        }
        
        // PENTING: Panggil updateWa di sini
        updateWa(productId); 
    }

    // Pilih ukuran
    if(e.target.classList.contains('size-option')){
        const productId = e.target.closest('[id^="sizes"]')?.id.replace('sizes','');
        if(productId) selectSize(productId,e.target.innerText);
    }
});
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        const header = e.target.closest('.collapse-text-header');
        if (!header) return;

        const targetSelector = header.getAttribute('data-bs-target');
        const collapseEl = document.querySelector(targetSelector);
        if (!collapseEl) return;

        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseEl);

        // Toggle manual
        if (collapseEl.classList.contains('show')) {
            bsCollapse.hide();
            header.classList.add('collapsed');
        } else {
            bsCollapse.show();
            header.classList.remove('collapsed');
        }
    });

    // Sync class saat animasi selesai
    const allCollapse = document.querySelectorAll('.collapse[id^="collapseDesc"]');
    allCollapse.forEach(collapseEl => {
        collapseEl.addEventListener('shown.bs.collapse', () => {
            const header = document.querySelector(`[data-bs-target="#${collapseEl.id}"]`);
            header?.classList.remove('collapsed');
        });

        collapseEl.addEventListener('hidden.bs.collapse', () => {
            const header = document.querySelector(`[data-bs-target="#${collapseEl.id}"]`);
            header?.classList.add('collapsed');
        });
    });
});

// === SCROLL PRODUK UNGGULAN ===
function scrollProduk(direction){
    const container = document.getElementById('produkContainer');
    const card = container?.querySelector('.product-card');
    if(!card) return;
    const cardWidth = card.offsetWidth + 16;
    container.scrollBy({ left: direction*cardWidth, behavior:'smooth' });
}
//clikk
document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function (event) {
            const modalId = modal.id.replace('productModal', '');
            const url = "{{ route('product.addClick', ['id' => '__ID__']) }}".replace('__ID__', modalId);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update jumlah dilihat di halaman dan modal
                    const clickEl = document.getElementById('clickCount' + modalId);
                    const modalClickEl = document.getElementById('modalClickCount' + modalId);
                    if(clickEl) clickEl.textContent = 'Dilihat: ' + data.click_count + ' kali';
                    if(modalClickEl) modalClickEl.textContent = 'Dilihat: ' + data.click_count + ' kali';
                }
            })
            .catch(err => console.error(err));
        }, { once: true }); // ✅ Pastikan hanya sekali per modal
    });
});
// --- FIX 2: SCRIPT GALERI DENGAN URL STORAGE YANG BENAR ---
// Data galeri dari controller, pastikan URL storage-nya benar
const galleryImages = @json($galeriTerbaru->map(fn($g) => asset('storage/' . $g->img)));
let currentIndex = 0;
const modalImg = document.getElementById('modalImg');

function showImage(index){
    if(modalImg && galleryImages[index]){
        modalImg.style.opacity=0;
        currentIndex=index;
        modalImg.src = galleryImages[currentIndex];
        setTimeout(()=>{modalImg.style.opacity=1},50);
    }
}

document.querySelectorAll('.gallery-img').forEach(img=>{
    img.addEventListener('click',()=>showImage(parseInt(img.dataset.index)));
});

document.getElementById('prevImg')?.addEventListener('click', ()=>{
    if(!galleryImages.length) return;
    showImage((currentIndex-1+galleryImages.length)%galleryImages.length);
});

document.getElementById('nextImg')?.addEventListener('click', ()=>{
    if(!galleryImages.length) return;
    showImage((currentIndex+1)%galleryImages.length);
});
// Navbar scroll
window.addEventListener('scroll', ()=>{
    const navbar = document.querySelector('.navbar');
    if(!navbar) return;
    navbar.classList.toggle('scrolled', window.scrollY>50);
});
window.addEventListener('load', ()=>document.querySelectorAll('.navbar').forEach(nav=>nav.style.opacity='1'));
/**
 * Fungsi untuk mendekode entitas HTML yang telah di-encode
 */
function decodeHtml(html) {
    const txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

/**
 * Fungsi untuk memformat plain text dengan baris baru (\n) 
 * menjadi struktur HTML paragraf (<p>) jika konten belum berupa HTML.
 */
function formatContentToHtml(plainTextContent) {
    if (!plainTextContent) return '';
    
    // Pisahkan konten berdasarkan baris baru (\r?\n)
    const paragraphs = plainTextContent.split(/\r?\n/);

    // Filter baris kosong dan bungkus dengan tag <p>
    const htmlContent = paragraphs
        .filter(p => p.trim() !== '')
        .map(p => `<p>${p.trim()}</p>`)
        .join('');
        
    return htmlContent;
}


document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('beritaDetailModal'); // ID disesuaikan

    if (detailModal) {
        detailModal.addEventListener('show.bs.modal', function (event) {
            // Pastikan yang memicu adalah tombol detail
            if (!event.relatedTarget.classList.contains('detail-btn')) return;

            const button = event.relatedTarget; 

            // Ambil data dari data attributes
            const title = button.getAttribute('data-title');
            const date = button.getAttribute('data-date');
            const location = button.getAttribute('data-location');
            const menu = button.getAttribute('data-menu');
            const img = button.getAttribute('data-img');
            const content = button.getAttribute('data-content'); // Konten masih dalam bentuk entity

            // Dapatkan elemen modal
            const modalTitle = detailModal.querySelector('#modal-title');
            const modalDate = detailModal.querySelector('#modal-date span');
            const modalLocation = detailModal.querySelector('#modal-location span');
            const modalMenu = detailModal.querySelector('#modal-menu span');
            const modalImg = detailModal.querySelector('#modal-img');
            const modalContent = detailModal.querySelector('#modal-content');

            // Isi elemen dengan data
            modalTitle.textContent = title;
            modalDate.textContent = date;
            modalLocation.textContent = location;
            modalMenu.textContent = menu;

            // Atur gambar
            const isPlaceholder = img.includes('Tidak+Ada+Gambar'); 
            
            if (img && !isPlaceholder) {
                modalImg.src = img;
                modalImg.alt = title;
                modalImg.style.display = 'block';
            } else {
                modalImg.style.display = 'none';
                modalImg.src = ''; 
            }

            // Memproses konten untuk pemformatan
            const decodedContent = decodeHtml(content);
            const isHtmlContent = decodedContent.trim().startsWith('<');

            if (isHtmlContent) {
                // Konten sudah berupa HTML, langsung gunakan
                modalContent.innerHTML = decodedContent;
            } else {
                // Konten adalah plain text, format menjadi <p>
                modalContent.innerHTML = formatContentToHtml(decodedContent);
            }
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
