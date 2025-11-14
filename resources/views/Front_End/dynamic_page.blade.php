{{-- File: resources/views/dynamic_page.blade.php --}}
@extends('layouts.app')

{{-- Pastikan helper View::exists() diimpor di file AppServiceProvider atau di controller jika diperlukan.
Secara default, ini tidak perlu di Blade, tapi saya tambahkan untuk kejelasan. --}}
@php
use Illuminate\Support\Facades\View;
@endphp

@section('content')

<div class="container py-5 mt-5">
<div class="row">
<div class="col-12">

        @if($menu_data->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                <h4 class="alert-heading mb-2">Belum Ada Konten!</h4>
                <p>Silakan tambahkan konten melalui menu <strong>Menu Data</strong> di halaman admin untuk menu <strong>{{ $menu->nama }}</strong>.</p>
            </div>
        @else
            
            @php
                // Ambil jenis konten dari item pertama (asumsi seragam)
                $contentType = $menu_data->first()->jenis_konten ?? 'statis';
                
                // KONSOLIDASI: dinamis_detail dan dinamis_link di mapping ke partial 'dinamis'
                if ($contentType === 'dinamis_detail' || $contentType === 'dinamis_link') {
                    $contentType = 'dinamis';
                }
            @endphp

            {{-- ========================================================== --}}
            {{-- LOGIKA BLOK TUNGGAL (GROUP LOGIC): media atau dinamis --}}
            {{-- Partial ini memiliki loop internal (horizontal swipe) dan dipanggil SEKALI. --}}
            {{-- ========================================================== --}}
            
            @if ($contentType === 'media' || $contentType === 'dinamis')
                @php
                    $viewName = 'partials.menu_content.' . $contentType;
                @endphp

                @if(View::exists($viewName))
                    {{-- Panggil partial SEKALI dengan SELURUH data koleksi --}}
                    @include($viewName, ['menu_data' => $menu_data, 'menu' => $menu])
                @else
                    <div class="alert alert-warning">
                        Template {{ $viewName }} tidak ditemukan.
                    </div>
                @endif

            {{-- ========================================================== --}}
            {{-- LOGIKA PER ITEM (INDIVIDUAL LOGIC): statis, organisasi, dll. --}}
            {{-- Partial ini hanya menampilkan satu item, jadi harus di-loop. --}}
            {{-- ========================================================== --}}
            @else
                @foreach ($menu_data as $item)
                    
                    <article class="mb-5 pb-4 border-bottom">

                        @php
                            // Logika penentuan view untuk item tunggal (statis, organisasi, dll.)
                            $viewContent = $item->jenis_konten ?? 'statis';
                            $viewName = 'partials.menu_content.' . $viewContent;

                            // Asumsi View::exists() sudah tersedia
                            $viewExists = View::exists($viewName);
                        @endphp

                        @if($viewExists)
                            {{-- Panggil partial PER ITEM, karena partial ini tidak memiliki loop internal --}}
                            @include($viewName, ['item' => $item, 'menu' => $menu])
                        @else
                            {{-- Fallback jika jenis_konten tidak dikenali atau partial hilang --}}
                            <div class="alert alert-warning">
                                Jenis konten '{{ $item->jenis_konten }}' tidak memiliki template tampilan yang sesuai.
                            </div>
                            {{-- Fallback ke statis jika ada partial-nya --}}
                            @if(View::exists('partials.menu_content.statis'))
                                @include('partials.menu_content.statis', ['item' => $item, 'menu' => $menu])
                            @endif
                        @endif

                    </article>
                @endforeach
            @endif
            
        @endif

    </div>
</div>


</div>

@endsection