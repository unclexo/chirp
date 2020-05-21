@if ($paginator->hasPages())
    <nav>
        <ul class="flex justify-between">
            @if ($paginator->onFirstPage())
                <li class="text-gray-500" aria-disabled="true"><span>← Recent</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="font-bold">← Recent</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="font-bold">Older →</a></li>
            @else
                <li class="text-gray-500" aria-disabled="true"><span>Older →</span></li>
            @endif
        </ul>
    </nav>
@endif
