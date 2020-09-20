@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><span class="disabled btn btn-outline-success">{{ 'Atpakaļ' }}</span></li>
        @else
            <li class="page-item">
                <a class="page-link-btn btn btn-outline-success"
                    href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ 'Atpakaļ' }}</a>
                </button>
            </li>
        @endif

        <span class="pages-counter">{{ $paginator->currentPage() . '. no ' . $paginator->lastPage() }}</span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link-btn btn btn-outline-success"
                    href="{{ $paginator->nextPageUrl() }}" rel="next">{{ 'Tālāk' }}</a></li>
        @else
            <li><span class="disabled btn btn-outline-success">{{ 'Tālāk' }}</span></li>
        @endif
    </div>
@endif
