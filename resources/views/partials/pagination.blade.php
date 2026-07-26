@php
    $pagination = $paginator->appends(request()->query());
@endphp

@if ($pagination->hasPages())
    <div class="pagination-wrapper d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 mt-4">
        <div class="text-muted small">
            Menampilkan {{ $pagination->firstItem() }} - {{ $pagination->lastItem() }} dari {{ $pagination->total() }}
            data
        </div>

        <nav aria-label="Pagination">
            <ul class="pagination mb-0">
                {{-- Previous --}}
                @if ($pagination->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Sebelumnya">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $pagination->previousPageUrl() }}" rel="prev"
                            aria-label="Sebelumnya">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pages --}}
                @php
                    $elements = $pagination->getUrlRange(1, $pagination->lastPage());
                @endphp

                @foreach ($elements as $page => $url)
                    <li class="page-item {{ $page == $pagination->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next --}}
                @if ($pagination->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $pagination->nextPageUrl() }}" rel="next"
                            aria-label="Berikutnya">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Berikutnya">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
