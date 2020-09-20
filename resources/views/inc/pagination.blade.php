@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><span class="disabled btn btn-outline-success">{{ __('Atpakaļ') }}</span></li>
        @else
            <li class="page-item">
                <a class="page-link-button btn btn-outline-success"
                    href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ __('Atpakaļ') }}</a>
                </button>
        @endif

        <span class="pages-counter">{{ $paginator->currentPage() . '. no ' . $paginator->lastPage() }}</span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link-btn btn btn-outline-success"
                    href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('Tālāk') }}</a></li>
        @else
            <li><span class="disabled btn btn-outline-success">{{ __('Tālāk') }}</span></li>
        @endif
    </div>
@endif
