<aside class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Dekranasda Logo">
        <span>Dekranasda</span>
    </div>

    <ul class="menu">
@auth
        {{-- =============================================== --}}
        {{-- MENU YANG HANYA BISA DIAKSES SETELAH LOGIN (@auth) --}}
        {{-- =============================================== --}}
        
        {{-- DASHBOARD (admin & operator) --}}
        <li>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i><span>Dashboard Admin</span>
                </a>
            @elseif(Auth::user()->role === 'operator')
                <a href="{{ route('operator.dashboard') }}" class="{{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i><span>Dashboard Operator</span>
                </a>
            @endif
        </li>

        {{-- PRODUK (semua role, link otomatis sesuai role) --}}
        <li>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.produk.index') }}" class="{{ request()->is('admin/produk*') ? 'active' : '' }}">
                    <i class="fas fa-gifts"></i><span>Produk</span>
                </a>
            @elseif(Auth::user()->role === 'operator')
                <a href="{{ route('operator.produk.index') }}" class="{{ request()->is('operator/produk*') ? 'active' : '' }}">
                    <i class="fas fa-gifts"></i><span>Produk</span>
                </a>
            @endif
        </li>

        {{-- TOKO (semua role, link otomatis sesuai role) --}}
        <li>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.toko.index') }}" class="{{ request()->is('admin/toko*') ? 'active' : '' }}">
                    <i class="fas fa-store"></i><span>Toko</span>
                </a>
            @elseif(Auth::user()->role === 'operator')
                <a href="{{ route('operator.toko.index') }}" class="{{ request()->is('operator/toko*') ? 'active' : '' }}">
                    <i class="fas fa-store"></i><span>Toko</span>
                </a>
            @endif
        </li>

        {{-- MENU, MENU DATA, & USERS (khusus admin) --}}
        @if(Auth::user()->role === 'admin')
            <li>
                <a href="{{ route('admin.menu.index') }}" class="{{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i><span>Menu</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.menu_data.index') }}" class="{{ request()->routeIs('admin.menu_data.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i><span>Menu Data</span>
                </a>
            </li>

            <li>
                {{-- Menggunakan route yang benar: 'admin.users.index' --}}
                <a href="{{ route('user.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i><span>User Admin</span>
                </a>
            </li>
        @endif
@endauth

        {{-- =============================================== --}}
        {{-- LINK PUBLIK (DIHAPUS SESUAI PERMINTAAN) --}}
        {{-- =============================================== --}}
        {{-- <li>
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-globe"></i><span>Halaman Utama Publik</span>
            </a>
        </li> --}}
    </ul>
</aside>
