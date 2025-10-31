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
        @foreach ($allProducts as $pr)
            {{-- HANYA TAMPILKAN PRODUK DENGAN KATEGORI "Unggulan" --}}
            @if ($pr->category === "Unggulan")
                @php
                    $firstVariant = $pr->variants->first(); 
                    // Prioritaskan: 1. Gambar Utama ($pr->img) -> 2. Gambar Varian Pertama -> 3. Default
                    $productImg = $pr->img ?? optional($firstVariant)->img ?? 'assets/default.jpg'; 
                    $productPrice = $pr->price ?? optional($firstVariant)->price ?? 0;
                    
                    // 💡 PERBAIKAN 1: Logika untuk mendapatkan Ukuran yang Tersedia dari Varian Pertama
                    $availableSizes = optional($firstVariant)->sizes ?? [];
                    $availableSizes = array_filter($availableSizes);
                @endphp

                <div class="product-card flex-shrink-0 me-3">
                    <div class="card h-100 text-center">
                        <img src="{{ $productImg }}" class="card-img-top" alt="{{ $pr->name }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ $pr->name }}</h6>
                            <p class="fw-bold harga-produk">Rp {{ number_format($productPrice,0,',','.') }}</p>
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
                                    <img id="mainImg{{ $pr->id }}" src="{{ $productImg }}" alt="{{ $pr->name }}" class="img-fluid">
                                </div>

                                <div class="col-md-6 p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h4 class="modal-title">{{ $pr->name }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <h5 class="text-danger fw-bold mb-3" id="price{{ $pr->id }}">Rp {{ number_format($productPrice,0,',','.') }}</h5>
                                    <p class="text-muted mb-3">{{ $pr->desc ?? 'Deskripsi tidak tersedia' }}</p>

                                    @if($pr->store)
                                        <div class="mb-3 p-2 bg-light rounded">
                                            <p class="mb-1"><strong>Toko:</strong> {{ $pr->store->name }}</p>
                                            <p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $pr->store->alamat }}</p>
                                        </div>
                                    @endif

                                    {{-- Pilih Warna --}}
                                    @if($pr->variants->count())
                                        <div class="mb-3">
                                            <label class="fw-semibold mb-2 d-block">Pilih Warna:</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($pr->variants as $variant)
                                                    <button type="button"
                                                            class="btn btn-outline-dark btn-sm color-btn {{ $loop->first ? 'active' : '' }}" {{-- 💡 PERBAIKAN 2: Tambah class 'active' --}}
                                                            data-product="{{ $pr->id }}"
                                                            data-color="{{ $variant->color }}"
                                                            data-img="{{ $variant->img ?? $productImg }}"
                                                            data-price="{{ $variant->price ?? $productPrice }}">
                                                        {{ ucfirst($variant->color) }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Pilih Ukuran --}}
                                        @if(!empty($availableSizes)) {{-- 💡 PERBAIKAN 3: Tampilkan Ukuran hanya jika ada data --}}
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

                                    {{-- Jumlah --}}
                                    <div class="mb-3">
                                        <label class="fw-semibold mb-2 d-block">Jumlah:</label>
                                        <input type="number" class="form-control w-50" value="1" min="1" id="qty{{ $pr->id }}">
                                    </div>

                                    {{-- WA --}}
                                    <a href="#"
                                        class="btn btn-wa w-100 mt-auto d-flex justify-content-center align-items-center gap-2 fw-semibold"
                                        data-wa="{{ $pr->store->telepon ?? '6280000000000' }}"
                                        data-store-name="{{ $pr->store->name ?? '' }}"
                                        data-store-address="{{ $pr->store->alamat ?? '' }}"
                                        onclick="sendWA({{ $pr->id }})">
                                        <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>

<!-- Berita Compact Responsive Swipe -->
<section id="berita" class="container py-5">
    <h2 class="section-title mb-4 text-center">Berita Terkini</h2>
    <div class="row g-4">
        {{-- Loop menggunakan variabel $news dari HomeController --}}
        @foreach ($news as $n)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    {{-- Mengakses kolom 'img' --}}
                    <img src="{{ asset('storage/'.$n->img) }}" class="card-img-top" alt="{{ $n->title }}">
                    <div class="card-body d-flex flex-column">
                        {{-- Mengakses kolom 'title' --}}
                        <h5 class="card-title">{{ $n->title }}</h5>
                        
                        {{-- FIX: Memformat kolom 'date' menjadi tanggal cantik --}}
                        <small class="text-muted mb-2">{{ \Carbon\Carbon::parse($n->date)->format('d F Y') }}</small>
                        
                        <p class="card-text flex-grow-1">
                            {{-- Mengakses kolom 'content' --}}
                            {{ Str::limit(strip_tags($n->content), 100) }}
                        </p>
                        
                        {{-- Link ke detail berita --}}
                        <a href="{{ route('berita.show', $n->id) }}" class="btn btn-custom mt-auto">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>



<!-- Galeri --><section id="galeri" class="container py-5">
    <h2 class="section-title">Galeri</h2>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        {{-- Loop menggunakan variabel $galeri --}}
        @foreach ($galeri as $i => $g)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column">
                    <div style="aspect-ratio: 4/3; overflow: hidden; border-radius:10px;">
                        {{-- FIX 1: Menggunakan asset('storage/') --}}
                        <img src="{{ asset('storage/' . $g->img) }}" 
                            class="img-fluid gallery-img" 
                            alt="{{ $g->title ?? 'Galeri ' . ($i+1) }}" 
                            data-bs-toggle="modal" data-bs-target="#galeriModal" data-index="{{ $i }}" 
                            style="width:100%; height:100%; object-fit:cover;">
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tombol Lihat Semua -->
    <div class="text-center mt-4">
        <a href="{{ route('galeri.index') }}" class="btn btn-custom">Lihat Semua Galeri</a>
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
    // Tidak perlu melakukan apa-apa di sini, cukup pastikan fungsi ini ada
    // Pilihan warna/ukuran sudah tercatat di DOM dengan class 'active'
    // Fungsi sendWA akan membaca status 'active' tersebut.
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

    const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
    window.open(waUrl,'_blank');
}

// === PILIH WARNA & UPDATE VARIANT (FIXED: Logika Sederhana) ===
document.addEventListener('click', function(e){
    if(e.target.classList.contains('color-btn')){
        const productId = e.target.dataset.product;
        const color = e.target.dataset.color;
        const product = allProducts.find(p=>p.id==productId);
        if(!product) return;
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
        if(priceEl) priceEl.innerText = formatRupiah(variant.price ?? 0);

        // Update active button warna
        document.querySelectorAll(`#productModal${productId} .color-btn`).forEach(b=>b.classList.remove('active'));
        e.target.classList.add('active');

        // Update ukuran jika ada
        const sizeWrapper = document.getElementById('sizeWrapper'+productId);
        const sizesContainer = document.getElementById('sizes'+productId);
        
        // Cek data sizes dari JSON yang sudah diexplode di Controller (array JS)
        if(variant.sizes && variant.sizes.length > 0){
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


// === SCROLL PRODUK UNGGULAN ===
function scrollProduk(direction){
    const container = document.getElementById('produkContainer');
    const card = container?.querySelector('.product-card');
    if(!card) return;
    const cardWidth = card.offsetWidth + 16;
    container.scrollBy({ left: direction*cardWidth, behavior:'smooth' });
}


// --- FIX 2: SCRIPT GALERI DENGAN URL STORAGE YANG BENAR ---
// Data galeri dari controller, pastikan URL storage-nya benar
const galleryImages = @json($galeri->map(fn($g) => asset('storage/' . $g->img)));
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
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
