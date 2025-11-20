{{-- PARTIAL: media.blade.php (Tampilan untuk Galeri Foto/Media - Grid View dengan Modal) --}}

@php
    use Illuminate\Support\Facades\Storage;

    $galeriList = $menu_data ?? collect([]);
@endphp

@once
<style>
    /* ====================================================== */
    /*                PERMINTAAN STYLE ANDA                   */
    /* ====================================================== */

    /* Geser modal galeri sedikit ke bawah agar tidak nabrak navbar */
    #galeriModal .modal-dialog {
        margin-top: 70px;
    }

    /* Grid responsif galeri */
    @media (max-width: 767.98px) {
        #galeri .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
        #galeri .col-md-4 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }
    }
    @media (min-width: 992px) {
        #galeri .col-lg-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }

    /* ======================= */
    /*      Gambar Modal       */
    /* ======================= */

    .modal-img-container {
        width: 100%;
        height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f8f8;
        border-radius: 10px;
        overflow: hidden;
        position: relative; /* penting untuk tombol ada di dalam */
    }

    .modal-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .modal-image.active {
        transform: scale(1.02);
    }

    /* Tinggi responsif */
    @media (max-width: 576px) {
        .modal-img-container { height: 320px; }
    }
    @media (min-width: 577px) and (max-width: 991px) {
        .modal-img-container { height: 400px; }
    }
    @media (min-width: 1200px) {
        .modal-img-container { height: 550px; }
    }

    /* ======================= */
    /* Tombol Navigasi Modern  */
    /* ======================= */

    /* --- POSISI BARU: tombol ada DI DALAM area gambar --- */
    .modal-btn {
        width: 50px;
        height: 50px;
        font-size: 1.8rem;
        background-color: rgba(255, 255, 255, 0.75);
        color: #333;
        border-radius: 50%;
        border: none;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        transform: translateY(-50%);
        z-index: 1060;
        position: absolute;
        top: 50%;
    }

    /* POSISI BARU – ADA DI DALAM CONTAINER */
    #prevImg { left: 15px; }
    #nextImg { right: 15px; }

    .modal-btn:hover {
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        transform: translateY(-50%) scale(1.15);
    }

    /* Tombol close */
    .modal-close {
        font-size: 1.6rem;
        color: #333;
        background: rgba(255, 255, 255, 0.75);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        position: absolute;
        top: 15px;
        right: 20px;
        z-index: 1070;
        transition: all 0.3s ease;
    }
    .modal-close:hover {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        transform: scale(1.15);
    }

    /* Responsive tombol modal */
    @media (max-width: 576px) {
        .modal-btn {
            width: 40px;
            height: 40px;
            font-size: 1.4rem;
        }
        #prevImg { left: 10px; }
        #nextImg { right: 10px; }
        .modal-close {
            font-size: 1.3rem;
            width: 32px;
            height: 32px;
        }
    }

    /* Tombol kembali */
    .btn-back-full {
        background-color: #a1866f;
        color: #fff;
        font-weight: 500;
        font-size: 1rem;
        padding: 10px 22px;
        border-radius: 35px;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-back-full:hover {
        background-color: #8c6b57;
        transform: translateY(-1px);
        color: #fff;
    }
    .btn-back-full i {
        font-size: 1.2rem;
        margin-right: 6px;
    }

    header h1 {
        font-size: clamp(1.8rem, 5vw, 3rem);
    }
    header p {
        font-size: clamp(1rem, 3vw, 1.2rem);
    }
</style>
@endonce


<section id="galeri" class="py-5">
    <h2 class="section-title">{{ $menu->nama ?? 'Galeri Lengkap' }}</h2>

    @if($galeriList->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Tidak ada foto di galeri ini.
        </div>
    @else
        <div class="row g-3">
            @foreach ($galeriList as $i => $g)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div style="aspect-ratio: 4/3; overflow: hidden; border-radius:10px;">
                            <img src="{{ Storage::url($g->img) }}"
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
           <a href="{{ url('home') }}#galeri" class="btn btn-back-full">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    @endif
</section>


{{-- ======================= --}}
{{--       MODAL GALERI     --}}
{{-- ======================= --}}
@once
<div class="modal fade" id="galeriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content position-relative p-3" style="background-color:#fffaf6; border-radius:16px;">

            <button type="button" class="modal-btn" id="prevImg">&#10094;</button>

            <div class="modal-img-container">
                <img id="modalImg" src="" class="modal-image">
            </div>

            <button type="button" class="modal-btn" id="nextImg">&#10095;</button>

            <button type="button" class="modal-close" data-bs-dismiss="modal">&times;</button>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const galeriList = @json($galeriList->map(fn($g) => Storage::url($g->img)));
        let currentIndex = 0;
        const modalImg = document.getElementById('modalImg');

        function showImage(index) {
            if (!modalImg || !galeriList.length) return;

            currentIndex = (index + galeriList.length) % galeriList.length;
            modalImg.classList.remove('active');
            modalImg.style.opacity = 0;

            setTimeout(() => {
                modalImg.src = galeriList[currentIndex];
                modalImg.style.opacity = 1;
                modalImg.classList.add('active');
            }, 80);
        }

        document.querySelectorAll('.gallery-img').forEach(img => {
            img.addEventListener('click', () => {
                const index = parseInt(img.dataset.index);
                if (!isNaN(index)) showImage(index);
            });
        });

        document.getElementById('prevImg')?.addEventListener('click', () => showImage(currentIndex - 1));
        document.getElementById('nextImg')?.addEventListener('click', () => showImage(currentIndex + 1));

        let touchStartX = 0, touchEndX = 0;

        document.getElementById('galeriModal')?.addEventListener('touchstart', e => {
            if (e.target.closest('#modalImg'))
                touchStartX = e.changedTouches[0].screenX;
        });

        document.getElementById('galeriModal')?.addEventListener('touchend', e => {
            if (touchStartX !== 0 && e.target.closest('#modalImg')) {
                touchEndX = e.changedTouches[0].screenX;
                const threshold = 50;

                if (touchEndX < touchStartX - threshold) showImage(currentIndex + 1);
                if (touchEndX > touchStartX + threshold) showImage(currentIndex - 1);

                touchStartX = 0;
            }
        });

    });
</script>
@endonce
