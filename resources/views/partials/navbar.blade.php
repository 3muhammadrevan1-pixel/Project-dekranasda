<nav class="navbar navbar-expand-lg fixed-top navbar-modern shadow-sm py-3">
  <div class="container">

    <!-- Brand / Logo Navbar -->
    <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/home') }}">
      <img src="{{ asset('assets/logo.png') }}" class="navbar-logo" style="height:48px;" alt="Logo Dekranasda">
      Dekranasda Kota Bogor
    </a>

    <!-- Tombol toggle untuk mobile -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Navbar -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto fw-semibold">
        <li class="nav-item"><a class="nav-link px-3" href="{{ url('/home') }}">Beranda</a></li>
       <li class="nav-item dropdown">
  <a class="nav-link px-3 d-flex align-items-center dropdown-toggle"
     href="#"
     id="tentangDropdown"
     role="button"
     data-bs-toggle="dropdown"
     aria-expanded="false">
    Tentang Kami
  </a>
  <ul class="dropdown-menu" aria-labelledby="tentangDropdown">
    <li><a class="dropdown-item" href="{{ route('about.sejarah') }}">Sejarah</a></li>
    <li><a class="dropdown-item" href="{{ route('organisasi.index') }}">Organisasi</a></li>
  </ul>
</li>
        <li class="nav-item"><a class="nav-link px-3" href="{{ url('/produk') }}">Produk</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="{{ url('/home#berita') }}">Berita</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="{{ url('/home#galeri') }}">Galeri</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="{{ url('/event') }}">Event</a></li>
      </ul>
    </div>

  </div>
</nav>
