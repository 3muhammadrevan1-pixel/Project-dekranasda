    @extends('layouts.app')

    @section('title', 'Event Dekranasda Kota Bogor')

    @section('content')
    <div class="container events">
        <h2>Daftar Event</h2>

        {{-- FIX 1: Menggunakan variabel $eventList (sesuai EventController) --}}
        <div class="carousel-container" id="eventCarousel">
            @foreach($eventList as $ev)
                <div class="event-card">
                    {{-- FIX 2: Menggunakan asset('storage/') dan kolom 'img' --}}
                    <img src="{{ asset('storage/'.$ev->img) }}" alt="{{ $ev->title }}">
                    
                    <div class="event-card-body">
                        {{-- Mengakses kolom 'title' --}}
                        <div class="event-card-title">{{ $ev->title }}</div>
                        
                        {{-- FIX 3: Memformat kolom 'date' --}}
                        <div class="event-meta">
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($ev->date)->format('d F Y') }}
                        </div>
                        
                        {{-- FIX 4: Menggunakan kolom 'location' (bukan lokasi) --}}
                        <div class="event-meta">
                            <i class="bi bi-geo-alt"></i>
                            {{ $ev->location }}
                        </div>
                        
                        {{-- FIX 5: Menggunakan kolom 'content' dan membatasi (Str::limit) --}}
                        <div class="event-card-desc">
                            {{ Str::limit(strip_tags($ev->content), 150) }}
                        </div>
                        
                        {{-- Mengakses kolom 'link' --}}
                        @if($ev->link)
                            <a href="{{ $ev->link }}" class="btn-custom" target="_blank">Detail Event</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endsection
