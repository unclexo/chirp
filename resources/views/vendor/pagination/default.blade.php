@if ($paginator->hasPages())
    <nav>
        <ul class="flex justify-around">
            @if ($paginator->onFirstPage())
                <li aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true" class="opacity-50">←</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" class="hover:text-yellow-500">←</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page"><span class="font-bold">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="hover:text-yellow-500">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" class="hover:text-yellow-500">→</a>
                </li>
            @else
                <li aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true" class="opacity-50">→</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
