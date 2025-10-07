@extends('layouts.app')

@section('title', 'Event Dekranasda Kota Bogor')

@section('content')
<div class="container events">
  <h2>Daftar Event</h2>

  <div class="carousel-container" id="eventCarousel">
    @foreach($events as $ev)
      <div class="event-card">
        <img src="{{ asset($ev->img) }}" alt="{{ $ev->title }}">
        <div class="event-card-body">
          <div class="event-card-title">{{ $ev->title }}</div>
          <div class="event-meta"><i class="bi bi-calendar-event"></i>{{ $ev->date }}</div>
          <div class="event-meta"><i class="bi bi-geo-alt"></i>{{ $ev->lokasi }}</div>
          <div class="event-card-desc">{{ $ev->desc }}</div>
          @if($ev->link)
            <a href="{{ $ev->link }}" class="btn-custom" target="_blank">Detail Event</a>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
