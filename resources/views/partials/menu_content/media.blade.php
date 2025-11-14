{{-- PARTIAL: media.blade.php (Tampilan untuk Galeri Foto/Media - Grid View dengan Modal) --}}

{{-- 
    PENTING: Partial ini berasumsi bahwa:
    1. Anda memiliki satu menu bertipe 'media'/'galeri' yang menampung banyak item.
    2. Partial ini dipanggil sekali (TIDAK di dalam loop di dynamic_page.blade.php).
    3. Variabel $menu_data berisi Collection dari semua item galeri (foto/video).
--}}

@php
    use Illuminate\Support\Facades\Storage;

    // Gunakan $menu_data dari controller, ganti nama agar sesuai dengan konteks lama.
    // Jika $menu_data adalah array/Collection dari item galeri, ini akan berhasil.
    $galeriList = $menu_data ?? collect([]);
@endphp

@once
<style>
    /* Styling khusus untuk modal galeri */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
        color: #0d6efd; /* Sesuai dengan text-primary Bootstrap */
    }
    .modal-btn {
        background: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        font-size: 2.5rem;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 1051;
        transform: translateY(-50%);
        transition: background 0.2s;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 10px;
        top: 50%;
    }
    .modal-btn:hover {
        background: rgba(0, 0, 0, 0.7);
    }
    .modal-close {
        position: absolute;
        top: 0;
        right: 0;
        margin: 1rem;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        font-size: 1.5rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        z-index: 1052;
        transition: background 0.2s;
    }
    .modal-close:hover {
        background: rgba(0, 0, 0, 0.7);
    }
    .modal-img-container {
        height: 80vh;
        padding: 20px;
    }
    .modal-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        transition: opacity 0.1s;
    }
    .gallery-img {
        cursor: pointer;
        transition: transform 0.3s ease-in-out;
    }
    .gallery-img:hover {
        transform: scale(1.05);
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
            {{-- Loop menggunakan variabel $galeriList --}}
            @foreach ($galeriList as $i => $g)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div style="aspect-ratio: 4/3; overflow: hidden; border-radius:10px;">
                            {{-- ✅ Ubah asset() menjadi Storage::url() agar kompatibel dengan storage/public --}}
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
            {{-- Tombol Kembali --}}
            <a href="javascript:window.history.length > 1 ? history.back() : '{{ url('/home') }}#galeri'" class="btn btn-back-full">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    @endif
</section>

{{-- Modal Galeri (Dipanggil hanya sekali dengan @once) --}}
@once
<div class="modal fade" id="galeriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content position-relative p-3" style="background-color: #fffaf6; border-radius: 16px;">
            {{-- Tombol prev/next --}}
            <button type="button" class="modal-btn position-absolute start-0" id="prevImg">&#10094;</button>
            <div class="modal-img-container d-flex justify-content-center align-items-center">
                <img id="modalImg" src="" class="img-fluid rounded modal-image">
            </div>
            <button type="button" class="modal-btn position-absolute end-0" id="nextImg">&#10095;</button>
            {{-- Tombol close --}}
            <button type="button" class="modal-close" data-bs-dismiss="modal">&times;</button>
        </div>
    </div>
</div>

{{-- Skrip JavaScript untuk Navigasi Modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ✅ Gunakan Storage::url() di array galeri untuk URL gambar storage
        const galeriList = @json($galeriList->map(fn($g) => Storage::url($g->img)));
        let currentIndex = 0;
        const modalImg = document.getElementById('modalImg');

        function showImage(index) {
            if (!modalImg || !galeriList.length) return;
            
            currentIndex = (index + galeriList.length) % galeriList.length;
            modalImg.style.opacity = 0;

            setTimeout(()=> {
                modalImg.src = galeriList[currentIndex]; 
                modalImg.style.opacity = 1;
            }, 60);
        }

        // Klik gambar grid → tampilkan modal
        document.querySelectorAll('.gallery-img').forEach(img => {
            img.addEventListener('click', () => {
                const index = parseInt(img.dataset.index);
                if (!isNaN(index)) showImage(index);
            });
        });

        // Tombol prev/next
        document.getElementById('prevImg')?.addEventListener('click', () => showImage(currentIndex - 1));
        document.getElementById('nextImg')?.addEventListener('click', () => showImage(currentIndex + 1));

        // Swipe (mobile)
        let touchStartX = 0, touchEndX = 0;
        document.getElementById('galeriModal')?.addEventListener('touchstart', e => { 
            if (e.target.closest('#modalImg')) touchStartX = e.changedTouches[0].screenX; 
        }, false);
        
        document.getElementById('galeriModal')?.addEventListener('touchend', e => {
            if (touchStartX !== 0 && e.target.closest('#modalImg')) {
                touchEndX = e.changedTouches[0].screenX;
                const threshold = 50;
                if (touchEndX < touchStartX - threshold) showImage(currentIndex + 1);
                if (touchEndX > touchStartX + threshold) showImage(currentIndex - 1);
                touchStartX = 0;
            }
        }, false);
    });
</script>
@endonce
