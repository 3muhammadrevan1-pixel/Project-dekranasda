@php
// Panggil Controller dari root App\Http\Controllers
$navMenus = \App\Http\Controllers\NavbarController::getActiveMenu();

// MAPPING URL/Route STATIS:

// HANYA untuk rute yang unik/spesial (misalnya: rute dengan anchor, rute resource, atau sub-menu)
$urlMapping = [
    'Beranda' => url('/home'), 
    'Produk' => url('/produk'),
    'Sejarah' => route('about.sejarah') ?? '#',
    
];

/**
 * Fungsi helper untuk menentukan URL
 * DIBUNGKUS dengan if (!function_exists) untuk mencegah error redeclare.
 */
if (!function_exists('getMenuUrl')) {
    function getMenuUrl($menu, $urlMapping) {
        // 1. Coba cari di mapping statis (Priority 1: Menu lama/spesial)
        if (isset($urlMapping[$menu->nama])) {
            return $urlMapping[$menu->nama]; 
        }

        // 2. Jika tidak ditemukan (Priority 2: Menu baru/dinamis), buat URL dinamis
        // Konversi "Nama Menu Baru" menjadi "nama-menu-baru"
        $slug = strtolower(str_replace(' ', '-', $menu->nama));

        try {
            // Menggunakan rute dinamis yang baru ditambahkan di web.php
            return route('page.dynamic', ['slug' => $slug]);
        } catch (\Exception $e) {
            // Fallback jika rute belum terdaftar
            return '#';
        }
    }
}
@endphp

<nav class="navbar navbar-expand-lg fixed-top navbar-modern shadow-sm py-3">
<div class="container">

    <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/home') }}">
        <img src="{{ asset('assets/logo.png') }}" class="navbar-logo" style="height:48px;" alt="Logo Dekranasda">
        Dekranasda Kota Bogor
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto fw-semibold">
            {{-- Loop menu utama (Parent Menu) --}}
            @foreach ($navMenus as $menu)
                
                {{-- Cek apakah menu utama memiliki sub-menu aktif --}}
                @if ($menu->children->isNotEmpty())
                    {{-- Render sebagai Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 d-flex align-items-center dropdown-toggle"
                            href="#" {{-- Link utama dropdown biasanya '#' atau URL statis --}}
                            id="dropdown-{{ $menu->id }}"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ $menu->nama }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown-{{ $menu->id }}">
                            {{-- Loop Sub-menu --}}
                            @foreach ($menu->children as $child)
                                <li><a class="dropdown-item" href="{{ getMenuUrl($child, $urlMapping) }}">{{ $child->nama }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    {{-- Render sebagai Menu Tunggal --}}
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ getMenuUrl($menu, $urlMapping) }}">
                            {{ $menu->nama }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

</div>


</nav>