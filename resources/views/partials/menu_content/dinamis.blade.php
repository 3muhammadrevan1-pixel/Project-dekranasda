@php
use Illuminate\Support\Str;
use Carbon\Carbon;
$items = $menu_data ?? collect([]);
$menuName = $menu->nama ?? 'Konten Dinamis';
@endphp

<section id="konten-dinamis" class="container py-5">
<h2 class="section-title text-center mb-5" style="color: #5c4033; font-weight: 700;">{{ $menuName }}</h2>

@if($items->isEmpty())
    <div class="alert alert-info text-center" role="alert">
        Saat ini belum ada konten tersedia untuk menu ini.
    </div>
@else
    {{-- Pembungkus utama untuk swipe horizontal --}}
    <div class="content-wrapper">
        @foreach ($items as $item)
            @php
                // Determine image path
                $imagePath = $item->img 
                    ? asset('storage/' . $item->img) 
                    : 'https://placehold.co/400x250/f5e6dc/5c4033?text=Tidak+Ada+Gambar';
                
                // Escape full content for modal data attribute
                // Menggunakan htmlspecialchars() untuk memastikan string aman di data-attribute
                $fullContent = htmlspecialchars($item->content, ENT_QUOTES, 'UTF-8');
                
                // Check mode: Link (Event) or Detail (Article)
                $isLinkMode = !empty($item->link);
            @endphp
            
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
                            @if($isLinkMode)
                                <span class="badge link-badge ms-2">Tautan Eksternal</span>
                            @else
                                <span class="badge detail-badge ms-2">Detail Konten</span>
                            @endif
                        </small>

                        {{-- Judul konten --}}
                        <h5 class="card-title fw-bold" style="color: #3e2f23; font-size: 1.15rem; line-height: 1.4;">{{ $item->title }}</h5>
                        
                        {{-- Cuplikan isi konten --}}
                        <p class="card-text flex-grow-1 mt-2" style="font-size: 0.95rem; color: #555;">
                            {{ Str::limit(strip_tags($item->content), 100) }}
                        </p>
                        
                        {{-- =================================== --}}
                        {{-- Tombol Aksi (Conditional) --}}
                        {{-- =================================== --}}

                        @if($isLinkMode)
                            {{-- MODE LINK --}}
                            <a 
                                href="{{ $item->link }}" 
                                class="btn btn-custom-sm mt-3"
                                target="_blank"
                            >
                                Kunjungi Tautan <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        @else
                            {{-- MODE DETAIL (Trigger Modal) --}}
                            <button 
                                type="button" 
                                class="btn btn-custom-sm mt-3 detail-btn"
                                data-bs-toggle="modal" 
                                data-bs-target="#detailModal"
                                data-title="{{ $item->title }}"
                                data-date="{{ Carbon::parse($item->date)->format('d F Y') }}"
                                data-location="{{ $item->location ?? 'Tidak Ada Lokasi' }}"
                                data-menu="{{ $menuName }}"
                                data-img="{{ $imagePath }}"
                                data-content="{{ $fullContent }}"
                            >
                                Baca Selengkapnya <i class="bi bi-arrow-right-short"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif


</section>

{{-- ================================================================= --}}
{{-- MODAL UNTUK TAMPILAN DETAIL (Hanya untuk item tanpa link) --}}
{{-- ================================================================= --}}

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
<div class="modal-content" style="border-radius: 16px;">
<div class="modal-header border-0 pb-0" style="padding: 20px 25px 0;">
<h5 class="modal-title fw-bold" id="detailModalLabel" style="color: #3e2f23;">Detail Konten</h5>
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
/* Global Styles */
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

{{-- ================================================================= --}}
{{-- JAVASCRIPT UNTUK MODAL DETAIL (SUDAH DISESUAIKAN) --}}
{{-- ================================================================= --}}

<script>
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
        
    // Jika semua baris kosong, kembalikan string kosong
    return htmlContent;
}


document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('detailModal');

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

            // =========================================================
            // PERUBAHAN UTAMA: Memproses konten untuk pemformatan
            // =========================================================
            const decodedContent = decodeHtml(content);
            
            // Cek apakah konten sudah berupa HTML (e.g. dimulai dengan <p>, <div>, <h>)
            // Pemeriksaan sederhana: apakah string yang di-trim dimulai dengan tag HTML
            const isHtmlContent = decodedContent.trim().startsWith('<');

            if (isHtmlContent) {
                // Konten sudah berupa HTML, langsung gunakan
                modalContent.innerHTML = decodedContent;
            } else {
                // Konten adalah plain text (berpotensi dengan baris baru), format menjadi <p>
                modalContent.innerHTML = formatContentToHtml(decodedContent);
            }
            // =========================================================
        });
    }
});


</script>