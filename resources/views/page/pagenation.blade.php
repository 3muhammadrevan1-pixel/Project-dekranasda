@if ($paginator->hasPages())
    <nav class="pagination-nav" role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination-list">

            {{-- Tautan Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li class="pagination-item disabled" aria-disabled="true">
                    {{-- Hanya menampilkan tanda panah untuk item non-aktif --}}
                    <span class="pagination-link pagination-prev-next">&laquo;</span>
                </li>
            @else
                <li class="pagination-item">
                    {{-- Hanya menampilkan tanda panah untuk item aktif --}}
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-link pagination-prev-next">&laquo;</a>
                </li>
            @endif

            {{-- Tautan Nomor Halaman --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination-item disabled" aria-disabled="true"><span class="pagination-link">{{ $element }}</span></li>
                @endif

                {{-- Array Tautan Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item active" aria-current="page"><span class="pagination-link pagination-number">{{ $page }}</span></li>
                        @else
                            <li class="pagination-item"><a href="{{ $url }}" class="pagination-link pagination-number">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tautan Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <li class="pagination-item">
                    {{-- Hanya menampilkan tanda panah untuk item aktif --}}
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-link pagination-prev-next">&raquo;</a>
                </li>
            @else
                <li class="pagination-item disabled" aria-disabled="true">
                    {{-- Hanya menampilkan tanda panah untuk item non-aktif --}}
                    <span class="pagination-link pagination-prev-next">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
