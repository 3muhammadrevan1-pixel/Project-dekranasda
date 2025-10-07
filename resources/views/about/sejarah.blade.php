{{-- resources/views/sejarah.blade.php --}}
@extends('layouts.app')

@section('title', 'Sejarah Dekranasda Kota Bogor')
{{-- @section('bodyClass', 'sejarah') --}}

@section('content')
<main>
  <h1 class="page-title">Sejarah Dekranasda Kota Bogor</h1>

  <div class="section">
    <div class="text">
      <span class="section-label">Sejarah Dekranasda</span>
      <h2>Kerajinan sebagai Bagian Budaya</h2>
      <p>Kerajinan sebagai suatu perwujudan perpaduan ketrampilan untuk menciptakan suatu karya
        dan nilai keindahan, merupakan bagian yang tidak terpisahkan dari suatu kebudayaan. Kerajinan tersebut tumbuh melalui proses waktu berabad-abad.
        Tumbuh kembang maupun laju dan merananya kerajinan
        sebagai warisan yang turun temurun tergantung dari beberapa faktor. Di antara faktor-faktor yang berpengaruh adalah
        transformasi masyarakat yang disebabkan oleh teknologi yang semakin modern, minat dan penghargaan masyarakat terhadap barang kerajinan dan tetap mumpuninya para perajin itu sendiri,
        baik dalam menjaga mutu dan kreativitas maupun dalam penyediaan produk kerajinan secara berkelanjutan.</p>
    </div>
    <div class="image">
      <img src="{{ asset('assets/d1.jpg') }}" alt="Kerajinan Budaya" />
    </div>
  </div>

  <div class="section reverse">
    <div class="text">
      <span class="section-label">Sejarah Dekranasda</span>
      <h2>Arti Penting Industri Kerajinan</h2>
      <p>Industri kerajinan Dekranasda Kota Bogor berperan penting dalam melestarikan budaya dan mendorong pertumbuhan ekonomi kreatif.
        Melalui pembinaan dan inovasi, Dekranasda menjadi wadah bagi perajin untuk meningkatkan kualitas produk, memperluas pemasaran,
        serta membuka peluang usaha yang berdampak pada kesejahteraan masyarakat.</p>
    </div>
    <div class="image">
      <img src="{{ asset('assets/d2.webp') }}" alt="Industri Kerajinan" />
    </div>
  </div>

  <div class="section">
    <div class="text">
      <span class="section-label">Sejarah Dekranasda</span>
      <h2>Latar Belakang Terbentuknya Dekranasda</h2>
      <p>Dekranasda lahir dari kesadaran akan pentingnya melestarikan kerajinan tradisional sebagai bagian dari warisan budaya bangsa.
        Perubahan zaman dan perkembangan teknologi membuat kerajinan perlu dibina agar tetap bertahan sekaligus mampu bersaing di pasar modern. Karena itu,
        dibentuklah Dewan Kerajinan Nasional dan Dekranasda di tingkat daerah sebagai wadah pembinaan, pelestarian, serta pengembangan industri kerajinan yang juga berperan dalam meningkatkan kesejahteraan para perajin.</p>
    </div>
    <div class="image">
      <img src="{{ asset('assets/d3.jpg') }}" alt="Berdirinya Dekranasda" />
    </div>
  </div>

  <div class="section reverse">
    <div class="text">
      <span class="section-label">Sejarah Dekranasda</span>
      <h2>Berdirinya DEKRANASDA</h2>
      <p>Dewan Kerajinan Nasional (Dekranas) resmi berdiri pada 3 Maret 1980 sebagai wadah pelestarian dan pengembangan kerajinan nusantara.
        Untuk memperkuat perannya di daerah, dibentuklah Dewan Kerajinan Nasional Daerah (Dekranasda) di setiap provinsi dan kabupaten/kota, termasuk Kota Bogor,
        yang berfungsi membina perajin lokal, meningkatkan kualitas produk, serta memperluas pemasaran kerajinan daerah.</p>
    </div>
    <div class="image">
      <img src="{{ asset('assets/d4.jpeg') }}" alt="Struktur Organisasi" />
    </div>
  </div>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll('.section');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if(entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    sections.forEach(section => observer.observe(section));
  });
</script>
</main>
@endsection
