{{-- resources/views/about/sejarah.blade.php --}}
@extends('layouts.app')

@section('title', 'Sejarah Dekranasda Kota Bogor')
{{-- @section('bodyClass', 'sejarah') --}}

@section('content')
<main>
  <h1 class="page-title">Sejarah Dekranasda Kota Bogor</h1>

  @php
      // pastikan $page->konten sudah berbentuk array
      $sections = is_array($page->konten) ? $page->konten : json_decode($page->konten, true);
  @endphp

  @foreach($sections as $index => $section)
    <div class="section {{ $index % 2 !== 0 ? 'reverse' : '' }}">
      <div class="text">
        <span class="section-label">Sejarah Dekranasda</span>
        <h2>{{ $section['title'] }}</h2>
        <p>{{ $section['text'] }}</p>
      </div>
      <div class="image">
        <img src="{{ asset($section['image']) }}" alt="{{ $section['title'] }}" />
      </div>
    </div>
  @endforeach
</main>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll('.section');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    sections.forEach(section => observer.observe(section));
  });
</script>
@endsection
