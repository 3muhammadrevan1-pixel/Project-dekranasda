@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')
<div class="container py-5">
    <h2 class="section-title">Semua Produk</h2>

    <!-- Filter -->
    <div class="mb-4 text-center">
        <button class="btn btn-custom me-2 mb-2 filter-btn active" data-category="all">Semua</button>
        <button class="btn btn-custom me-2 mb-2 filter-btn" data-category="unggulan">Unggulan</button>
        <button class="btn btn-custom me-2 mb-2 filter-btn" data-category="terbaru">Terbaru</button>
        @foreach($categories as $cat)
            <button class="btn btn-custom me-2 mb-2 filter-btn" data-category="{{ strtolower($cat) }}">
                {{ $cat }}
            </button>
        @endforeach
    </div>

    <!-- Grid Produk -->
    <div class="d-flex flex-wrap gap-3 justify-content-center" id="productGrid">
        @foreach($allProducts as $pr)
            @php
                $isTop = $topProducts->contains('id', $pr->id);
                $isLatest = $latestProducts->contains('id', $pr->id);
            @endphp
            <div class="product-card" 
                 data-category="{{ strtolower($pr->category) }} {{ $isTop ? 'unggulan' : '' }} {{ $isLatest ? 'terbaru' : '' }}"
                 data-click="{{ $pr->click_count }}">
                <div class="card h-100 text-center">
                    <img src="{{ asset('storage/' . ($pr->img ?? optional($pr->variants->first())->img)) }}" 
                         class="card-img-top" 
                         alt="{{ $pr->name }}">

                    <div class="card-body">
                        <h6 class="card-title">{{ $pr->name }}</h6>
                        <p class="fw-bold harga-produk">
                            Rp {{ number_format($pr->price ?? optional($pr->variants->first())->price, 0, ',', '.') }}
                        </p>
                        <p class="text-muted small" id="clickCount{{ $pr->id }}">
                            Dilihat: {{ $pr->click_count }} kali
                        </p>
                        <button class="btn btn-custom w-100 open-modal-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#productModal{{ $pr->id }}" 
                                data-product-id="{{ $pr->id }}">
                            Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Produk -->
            <div class="modal fade" id="productModal{{ $pr->id }}" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content p-0">
                        <div class="row g-0">
                            <!-- Gambar Produk -->
                            <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">
                                <img id="mainImg{{ $pr->id }}" 
                                     src="{{ asset('storage/' . ($pr->img ?? optional($pr->variants->first())->img)) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="{{ $pr->name }}">
                            </div>

                            <!-- Detail Produk -->
                            <div class="col-md-6 p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h4 class="modal-title">{{ $pr->name }}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <h5 class="text-danger fw-bold mb-3" id="price{{ $pr->id }}">
                                    Rp {{ number_format($pr->price ?? optional($pr->variants->first())->price, 0, ',', '.') }}
                                </h5>

                                <p class="text-muted mb-3">{{ $pr->desc }}</p>

                                @if($pr->store)
                                    <div class="mb-3 p-2 bg-light rounded">
                                        <p class="mb-1"><strong>Toko:</strong> {{ $pr->store->name }}</p>
                                        <p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $pr->store->alamat }}</p>
                                    </div>
                                @endif

                                <!-- Pilih Warna -->
                                @if($pr->variants->count())
                                    <label class="fw-semibold mb-1">Pilih Warna:</label>
                                    <div class="mb-3 d-flex flex-wrap gap-2">
                                        @foreach($pr->variants as $variant)
                                            <button class="btn btn-outline-dark btn-sm color-btn {{ $loop->first ? 'active' : '' }}"
                                                    data-product="{{ $pr->id }}"
                                                    data-color="{{ $variant->color }}"
                                                    data-img="{{ asset('storage/' . $variant->img) }}"
                                                    data-price="{{ $variant->price }}">
                                                {{ $variant->color }}
                                            </button>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Pilih Ukuran -->
                                @php
                                    $firstVariant = $pr->variants->first();
                                    $productType = strtolower($pr->type ?? 'none'); 
                                @endphp
                                @if($productType != 'none' && $firstVariant && is_array($firstVariant->sizes) && count($firstVariant->sizes))
                                    <div class="mb-3 size-wrapper" id="sizeWrapper{{ $pr->id }}">
                                        <label class="fw-semibold mb-2 d-block">Pilih Ukuran:</label>
                                        <div class="d-flex flex-wrap gap-2" id="sizes{{ $pr->id }}">
                                            @foreach($firstVariant->sizes as $s)
                                                <button type="button"
                                                        class="btn btn-outline-secondary btn-sm size-option {{ $loop->first ? 'active' : '' }}"
                                                        onclick="selectSize({{ $pr->id }}, '{{ $s }}')">
                                                    {{ $s }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <label class="fw-semibold mb-1">Jumlah:</label>
                                <input type="number" class="form-control mb-3 w-50" value="1" min="1" id="qty{{ $pr->id }}">

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

                        <!-- Produk Lainnya -->
                        <div class="p-4 border-top">
                            <h6 class="related-title mb-3">Produk Lainnya</h6>
                            <div class="related-wrapper">
                                @foreach($allProducts as $other)
                                    @if($other->id != $pr->id)
                                        <div class="related-card card text-center shadow-sm">
                                            <img src="{{ asset('storage/' . ($other->img ?? optional($other->variants->first())->img)) }}" 
                                                 alt="{{ $other->name }}">
                                            <div class="card-body p-2">
                                                <p class="small fw-semibold mb-1">{{ $other->name }}</p>
                                                <p class="harga-produk small mb-2">
                                                    Rp {{ number_format($other->price ?? optional($other->variants->first())->price, 0, ',', '.') }}
                                                </p>
                                                <button class="btn btn-sm btn-custom w-100"
                                                        onclick="switchModal({{ $pr->id }}, {{ $other->id }})">
                                                    Lihat
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
const allProducts = @json($allProductsJs);

// Tambah click_count saat modal dibuka
document.querySelectorAll('.open-modal-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.productId;
        fetch(`/product/click/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                // Update langsung tampilan jumlah dilihat
                const el = document.getElementById('clickCount'+id);
                if(el) el.innerText = `Dilihat: ${data.click_count} kali`;

                // Update data-click untuk sorting
                const card = document.querySelector(`.product-card[data-category*="${id}"]`);
                if(card) card.dataset.click = data.click_count;
            }
        });
    });
});

// Filter produk
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const category = btn.dataset.category.toLowerCase();
        const container = document.getElementById('productGrid');
        const cards = Array.from(container.querySelectorAll('.product-card'));

        cards.forEach(card => {
            card.style.display = (category === 'all' || card.dataset.category.toLowerCase().includes(category))
                ? 'flex'
                : 'none';
        });

        // Sort ulang produk unggulan & terbaru saat filter
        if(category === 'unggulan'){
            cards.sort((a,b) => parseInt(b.dataset.click) - parseInt(a.dataset.click));
            cards.forEach(c => container.appendChild(c));
        } else if(category === 'terbaru'){
            cards.sort((a,b) => b.dataset.category.includes('terbaru') - a.dataset.category.includes('terbaru'));
            cards.forEach(c => container.appendChild(c));
        }
    });
});

// Format Rupiah
function formatRupiah(angka) {
    return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Variant warna
document.querySelectorAll('.color-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.product;
        const color = this.dataset.color;
        const img = this.dataset.img;
        const price = this.dataset.price;

        document.getElementById(`mainImg${id}`).src = img;
        document.getElementById(`price${id}`).innerText = formatRupiah(price);

        document.querySelectorAll(`#productModal${id} .color-btn`).forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const product = allProducts.find(p => p.id == id);
        const variant = product.variants.find(v => v.color === color);
        const sizesDiv = document.getElementById(`sizes${id}`);
        sizesDiv.innerHTML = '';

        if (variant.sizes && variant.sizes.length > 0) {
            variant.sizes.forEach(s => {
                const btn = document.createElement("button");
                btn.className = "btn btn-outline-secondary btn-sm size-option";
                btn.innerText = s;
                btn.setAttribute('onclick', `selectSize(${id}, '${s}')`);
                sizesDiv.appendChild(btn);
            });
        } else {
            const btn = document.createElement("button");
            btn.className = "btn btn-outline-secondary btn-sm";
            btn.innerText = "Tidak tersedia";
            btn.disabled = true;
            sizesDiv.appendChild(btn);
        }
    });
});

// Pilih ukuran
function selectSize(id, size) {
    const sizesDiv = document.getElementById('sizes' + id);
    sizesDiv.querySelectorAll('.size-option').forEach(b => b.classList.remove('active'));
    const btn = Array.from(sizesDiv.querySelectorAll('.size-option')).find(b => b.innerText === size);
    if (btn) btn.classList.add('active');
}

// Ganti modal produk
function switchModal(currentId, targetId) {
    const current = document.getElementById(`productModal${currentId}`);
    const target = document.getElementById(`productModal${targetId}`);
    bootstrap.Modal.getInstance(current).hide();
    new bootstrap.Modal(target).show();
}

// Kirim WhatsApp
function sendWA(productId) {
    const pr = allProducts.find(p => p.id == productId);
    if (!pr) return;
    const qty = document.getElementById(`qty${productId}`).value || 1;
    const selectedColor = document.querySelector(`#productModal${productId} .color-btn.active`)?.innerText || '';
    const selectedSize = document.querySelector(`#sizes${productId} .size-option.active`)?.innerText || '';

    const waBtn = document.querySelector(`#productModal${productId} .btn-wa`);
    const waNumber = waBtn.dataset.wa;
    const storeName = waBtn.dataset.storeName || (pr.store?.name || '');
    const storeAddress = waBtn.dataset.storeAddress || (pr.store?.alamat || '');

    let colorLine = selectedColor ? `Warna: ${selectedColor}\n` : '';
    let sizeLine = selectedSize ? `Ukuran: ${selectedSize}\n` : '';

    const message = `Halo Admin, saya ingin memesan:
Produk: ${pr.name}
Toko: ${storeName}
Alamat: ${storeAddress}
${colorLine}${sizeLine}Jumlah: ${qty}`;

    const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
    window.open(waUrl, '_blank');
}
</script>
@endsection
