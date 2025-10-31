@extends('layouts.app')

@section('title', 'Galeri Dekranasda')  

@section('content')
<section id="galeri" class="container py-5">
    <h2 class="section-title">Galeri Lengkap Dekranasda Bogor</h2>
    <div class="row g-3">
        {{-- Loop menggunakan variabel $galeriList --}}
        @foreach ($galeriList as $i => $g)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
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
        {{-- Tombol Kembali: Coba kembali ke halaman sebelumnya atau ke home#galeri --}}
        <a href="javascript:window.history.length > 1 ? history.back() : '{{ url('/home') }}#galeri'" class="btn btn-back-full">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>
</section>

<!-- Modal Galeri -->
<div class="modal fade" id="galeriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content position-relative p-3" style="background-color: #fffaf6; border-radius: 16px;">
            <button type="button" class="modal-btn position-absolute top-50 start-0" id="prevImg">&#10094;</button>
            <div class="modal-img-container d-flex justify-content-center align-items-center">
                <img id="modalImg" src="" class="img-fluid rounded modal-image">
            </div>
            <button type="button" class="modal-btn position-absolute top-50 end-0" id="nextImg">&#10095;</button>
            <button type="button" class="modal-close" data-bs-dismiss="modal">&times;</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // FIX: Memastikan galleryImages sudah full URL dengan asset('storage/')
    // Menggunakan variabel $galeriList dari controller
    const galleryImages = @json($galeriList->map(fn($g) => asset('storage/' . $g->img)));
    let currentIndex = 0;
    const modalImg = document.getElementById('modalImg');

    function showImage(index) {
        if (!modalImg || !galleryImages.length) return;
        
        // Memastikan indeks berputar (loop)
        currentIndex = (index + galleryImages.length) % galleryImages.length;
        
        modalImg.style.opacity = 0;
        modalImg.src = galleryImages[currentIndex]; 
        setTimeout(()=> modalImg.style.opacity = 1, 60);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.gallery-img').forEach(img => {
            img.addEventListener('click', () => {
                const index = parseInt(img.dataset.index);
                if (!isNaN(index)) showImage(index);
            });
        });

        document.getElementById('prevImg')?.addEventListener('click', () => {
            showImage(currentIndex - 1);
        });
        document.getElementById('nextImg')?.addEventListener('click', () => {
            showImage(currentIndex + 1);
        });

        // Swipe kiri kanan untuk navigasi modal (Touch support)
        let touchStartX = 0, touchEndX = 0;
        modalImg?.addEventListener('touchstart', e => { 
            touchStartX = e.changedTouches[0].screenX; 
        });
        modalImg?.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            // Geser ke kiri (swipe kanan ke kiri)
            if (touchEndX < touchStartX - 50) showImage(currentIndex + 1);
            // Geser ke kanan (swipe kiri ke kanan)
            if (touchEndX > touchStartX + 50) showImage(currentIndex - 1);
        });
    });
</script>
@endsection
