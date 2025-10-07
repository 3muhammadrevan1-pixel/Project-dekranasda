<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dekranasda Kota Bogor')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/css/footer.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/css/program.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/css/berita.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/css/organisasi.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/css/produk.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/css/modal.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/assets/css/event.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/css/sejarah.css') }}">

</head>
<body>

  {{-- Navbar --}}
  @include('partials.navbar')

  {{-- Konten Dinamis --}}
  
    @yield('content')


  {{-- Footer --}}
  @include('partials.footer')  

  <!-- Bootstrap JS Bundle (sudah termasuk Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="{{ asset('/assets/js/app.js') }}"></script>

  @yield('scripts')
</body>
</html>
