{{-- File: resources/views/dynamic_page.blade.php --}}
@extends('layouts.app')

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
                // Ambil jenis konten dari item pertama
                $contentType = $menu_data->first()->jenis_konten ?? 'statis';

                // Konsolidasi jenis dinamis
                if ($contentType === 'dinamis_detail' || $contentType === 'dinamis_link') {
                    $contentType = 'dinamis';
                }
            @endphp

            {{-- ========================================================== --}}
            {{--          BLOK TUNGGAL: dinamis & media menggunakan view    --}}
            {{-- ========================================================== --}}
            
            @if ($contentType === 'media' || $contentType === 'dinamis')
                @php
                    $viewName = 'partials.menu_content.' . $contentType;
                @endphp

                @if(View::exists($viewName))
                    {{-- View hanya dipanggil sekali, karena partial sudah punya loop --}}
                    @include($viewName, [
                        'menu_data' => $menu_data,
                        'menu'      => $menu
                    ])
                @else
                    <div class="alert alert-warning">
                        Template {{ $viewName }} tidak ditemukan.
                    </div>
                @endif

            {{-- ========================================================== --}}
            {{--           BLOK PER ITEM: statis, organisasi, lainnya        --}}
            {{-- ========================================================== --}}
            @else

                {{-- ============================================== --}}
                {{-- PERBAIKAN KHUSUS STATIS: hanya 1 card per menu   --}}
                {{-- ============================================== --}}
                @if($contentType === 'statis')

                    {{-- CARD TUNGGAL UNTUK SEMUA DATA STATIS --}}
                    <div class="mb-5 pb-4">

                        @php
                            $viewName = 'partials.menu_content.statis';
                        @endphp

                        @if(View::exists($viewName))
                            
                            {{-- Default hanya tampilkan item pertama --}}
                            @php
                                $item = $menu_data->first();
                            @endphp

                            @include($viewName, [
                                'item' => $item,
                                'menu' => $menu,
                                'menu_data' => $menu_data   {{-- kirim semua data bila partial ingin dipakai --}}
                            ])

                        @else
                            <div class="alert alert-warning">
                                Template statis tidak ditemukan.
                            </div>
                        @endif

                    </div>

                @else
                    {{-- ============================================ --}}
                    {{-- Jenis NON-statis tetap menggunakan loop        --}}
                    {{-- ============================================ --}}
                    @foreach ($menu_data as $item)
                        
                        <article class="mb-5 pb-4 border-bottom">

                            @php
                                $viewContent = $item->jenis_konten ?? 'statis';
                                $viewName = 'partials.menu_content.' . $viewContent;
                                $viewExists = View::exists($viewName);
                            @endphp

                            @if($viewExists)

                                @include($viewName, [
                                    'item' => $item,
                                    'menu' => $menu
                                ])

                            @else
                                <div class="alert alert-warning">
                                    Jenis konten '{{ $item->jenis_konten }}' tidak memiliki template tampilan.
                                </div>
                                
                                @if(View::exists('partials.menu_content.statis'))
                                    @include('partials.menu_content.statis', [
                                        'item' => $item,
                                        'menu' => $menu
                                    ])
                                @endif
                            @endif

                        </article>
                    @endforeach

                @endif
            @endif
            
        @endif

    </div>
</div>
</div>

@endsection
