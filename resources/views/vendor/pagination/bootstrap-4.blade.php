@if ($paginator->hasPages())
<div class="styled-pagination text-center">
    <nav>
        <ul class="clearfix">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li><a href="javascript:" class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')"><span class="fa fa-caret-left"></span></a></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><span class="fa fa-caret-left"></span></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a href="javascript:" class="active">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><span class="fa fa-caret-right"></span></a></li>
            @else
                <li><a href="javascript:" class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')"><span class="fa fa-caret-right"></span></a></li>
            @endif
        </ul>
    </nav>
</div>
@endif
