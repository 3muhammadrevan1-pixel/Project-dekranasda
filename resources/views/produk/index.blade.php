@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')
<div class="container py-5">
  <h2 class="section-title">Semua Produk</h2>

  <!-- Filter -->
  <div class="mb-4 text-center">
    <button class="btn btn-custom me-2 mb-2 filter-btn active" data-category="all">Semua</button>
    @foreach($categories as $cat)
      <button class="btn btn-custom me-2 mb-2 filter-btn" data-category="{{ $cat }}">
        {{ $cat }}
      </button>
    @endforeach
  </div>

  <!-- Grid Produk -->
  <div class="d-flex flex-wrap gap-3 justify-content-center" id="productGrid">
    @foreach($allProducts as $pr)
     <div class="product-card" data-category="{{ strtolower($pr->category) }}">
        <div class="card h-100 text-center">
          <img src="{{ $pr->img ?? optional($pr->variants->first())->img }}" 
               class="card-img-top" 
               alt="{{ $pr->name }}">
          <div class="card-body">
            <h6 class="card-title">{{ $pr->name }}</h6>
            <p class="fw-bold harga-produk">
              Rp {{ number_format($pr->price ?? optional($pr->variants->first())->price, 0, ',', '.') }}
            </p>
            <button class="btn btn-custom w-100" data-bs-toggle="modal" data-bs-target="#productModal{{ $pr->id }}">
              Detail
            </button>
          </div>
        </div>
      </div>

      <!-- Modal produk -->
      <div class="modal fade" id="productModal{{ $pr->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content p-0">
            <div class="row g-0">
              <!-- Gambar -->
              <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">
                <img id="mainImg{{ $pr->id }}" 
                     src="{{ $pr->img ?? optional($pr->variants->first())->img }}" 
                     class="img-fluid rounded shadow-sm" 
                     alt="{{ $pr->name }}">
              </div>

              <!-- Detail -->
              <div class="col-md-6 p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <h4 class="modal-title">{{ $pr->name }}</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <h5 class="text-danger fw-bold mb-3" id="price{{ $pr->id }}">
                  Rp {{ number_format($pr->price ?? optional($pr->variants->first())->price, 0, ',', '.') }}
                </h5>
                <p class="text-muted mb-3">{{ $pr->desc }}</p>

                {{-- Info Toko --}}
                @if($pr->store)
                  <div class="mb-3 p-2 bg-light rounded">
                    <p class="mb-1"><strong>Toko:</strong> {{ $pr->store->name }}</p>
                    <p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $pr->store->alamat }}</p>
                  </div>
                @endif

                {{-- Warna --}}
                @if($pr->variants->count())
                  <label class="fw-semibold mb-1">Pilih Warna:</label>
                  <div class="mb-3 d-flex flex-wrap gap-2">
                    @foreach($pr->variants as $variant)
                      <button class="btn btn-outline-dark btn-sm color-btn"
                              data-product="{{ $pr->id }}"
                              data-color="{{ $variant->color }}"
                              data-img="{{ $variant->img }}"
                              data-price="{{ $variant->price }}">
                        {{ $variant->color }}
                      </button>
                    @endforeach
                  </div>
                @endif

              
                {{-- Ukuran --}}
                  {{-- Ukuran --}}
@php
    $firstVariant = $pr->variants->first();
@endphp
{{-- CEK BARU: Pastikan sizes adalah array dan tidak kosong --}}
@if($firstVariant && is_array($firstVariant->sizes) && count($firstVariant->sizes))
    <div class="mb-3 size-wrapper" id="sizeWrapper{{ $pr->id }}">
        <label class="fw-semibold mb-2 d-block">Pilih Ukuran:</label>
        <div class="d-flex flex-wrap gap-2" id="sizes{{ $pr->id }}">
            @foreach($firstVariant->sizes as $s)
                {{-- Hapus logika is_string() dan $s->size, karena $s sudah pasti string ukuran --}}
                <button type="button"
                        class="btn btn-outline-secondary btn-sm size-option"
                        onclick="selectSize({{ $pr->id }}, '{{ $s }}')">
                    {{ $s }}
                </button>
            @endforeach
        </div>
    </div>
@endif


                {{-- Qty --}}
                <label class="fw-semibold mb-1">Jumlah:</label>
                <input type="number" class="form-control mb-3 w-50" value="1" min="1" id="qty{{ $pr->id }}">

                {{-- WhatsApp --}}
                <a href="#"
                  class="btn btn-wa w-100 mt-auto d-flex justify-content-center align-items-center gap-2 fw-semibold"
                  data-wa="{{ $pr->store->telepon ?? '6280000000000' }}"
                  data-store-name="{{ $pr->store->name ?? '' }}"
                  data-store-address="{{ $pr->store->alamat ?? '' }}"
                  data-product-id="{{ $pr->id }}"
                  onclick="sendWA({{ $pr->id }})">
                  <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
                </a>
              </div>
            </div>

            <!-- Produk lain -->
            <div class="p-4 border-top">
              <h6 class="related-title mb-3">Produk Lainnya</h6>
              <div class="related-wrapper">
                @foreach($allProducts as $other)
                  @if($other->id != $pr->id)
                    <div class="related-card card text-center shadow-sm">
                      <img src="{{ $other->img ?? optional($other->variants->first())->img }}" 
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

// === FILTER PRODUK ===
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const category = btn.dataset.category.toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => {
      card.style.display = (category === 'all' || card.dataset.category.toLowerCase() === category) 
        ? 'flex' 
        : 'none';
    });
  });
});

// === FORMAT RUPIAH ===
function formatRupiah(angka) {
  return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// === GANTI VARIANT ===
document.querySelectorAll('.color-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    const id = this.dataset.product;
    const color = this.dataset.color;
    const img = this.dataset.img;
    const price = this.dataset.price;

    // Update gambar & harga
    document.getElementById("mainImg"+id).src = img;
    document.getElementById("price"+id).innerText = formatRupiah(price);

    // Active button warna
    document.querySelectorAll(`#productModal${id} .color-btn`).forEach(b => b.classList.remove('active'));
    this.classList.add('active');

    // Update ukuran sesuai variant
   const product = allProducts.find(p => p.id == id);
        const variant = product.variants.find(v => v.color === color);
        const sizesDiv = document.getElementById("sizes"+id);
        sizesDiv.innerHTML = '';

    if (variant.sizes && variant.sizes.length > 0) {
            variant.sizes.forEach(s => {
                // BARIS BARU: Langsung ambil s (karena s sudah string ukuran)
                const sizeVal = s; 
                
                // BARIS LAMA DIHAPUS: const sizeVal = typeof s === 'string' ? s : s.size;
                
                const btn = document.createElement("button");
                btn.className = "btn btn-outline-secondary btn-sm size-option";
                btn.innerText = sizeVal;
                btn.onclick = () => selectSize(id, sizeVal);
                sizesDiv.appendChild(btn);
            });
        } else {
          const btn = document.createElement("button");
          btn.className = "btn btn-outline-secondary btn-sm";
          btn.innerText = "Tidak tersedia";
          btn.disabled = true;
          sizesDiv.appendChild(btn);
        }

    updateWa(id);
  });
});

// === PILIH SIZE ===
function selectSize(id, size) {
  const sizesDiv = document.getElementById('sizes' + id);
  sizesDiv.querySelectorAll('.size-option').forEach(b => b.classList.remove('active'));
  const btn = Array.from(sizesDiv.querySelectorAll('.size-option')).find(b => b.innerText === size);
  if (btn) btn.classList.add('active');
  updateWa(id);
}

// === SWITCH MODAL ===
function switchModal(currentId, targetId) {
  const current = document.getElementById('productModal' + currentId);
  const target = document.getElementById('productModal' + targetId);

  bootstrap.Modal.getInstance(current).hide();
  new bootstrap.Modal(target).show();
}

// === UPDATE WA ===
function sendWA(productId){
  const pr = allProducts.find(p => p.id == productId);
  if(!pr) return;

  const qty = document.getElementById('qty'+productId).value || 1;
  const selectedColor = document.querySelector('#productModal'+productId+' .color-btn.active')?.innerText || '';
  const selectedSize = document.querySelector('#sizes'+productId+' .size-option.active')?.innerText || '';

  const waBtn = document.querySelector('#productModal'+productId+' .btn-wa');
  const waNumber = waBtn.dataset.wa;
  const storeName = waBtn.dataset.storeName || (pr.store?.name || '');
  const storeAddress = waBtn.dataset.storeAddress || (pr.store?.alamat || '');

  const message = `Halo Admin, saya ingin memesan:
Produk: ${pr.name}
Toko: ${storeName}
Alamat: ${storeAddress}
Warna: ${selectedColor}
Ukuran: ${selectedSize}
Jumlah: ${qty}`;

  const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
  window.open(waUrl,'_blank');
}
</script>
@endsection
