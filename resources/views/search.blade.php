<x-layouts.full>
    <h2 class="font-semibold leading-none text-center text-xl">Search results for "{{ $terms }}"</h2>

    <div class="mt-8">
        <form method="GET" action="@route('likes.search')" class="bg-gray-900 flex items-center justify-center rounded-full">
            <input type="hidden" name="sort_by" value="{{ $sortBy }}">

            <label for="q" class="sr-only">Search:</label>

            <input type="search" id="terms" name="terms" value="{{ old('terms') ?? $terms }}" placeholder="Type some keywords." class="appearance-none bg-transparent flex-grow pl-6 py-3 placeholder-gray-600 w-full">

            <button type="submit" class="bg-blue-500 hover:bg-blue-400 font-bold px-8 py-3 rounded-full text-white">
                Search
            </button>
        </form>

        <p class="mt-8 text-center">
            Sort by
            <a href="@route('likes.search', [
                'terms' => $terms,
            ])" class="font-semibold @if (! $sortBy) text-yellow-500 @else hover:text-yellow-500 @endif">
                relevance
            </a>
            or
            <a href="@route('likes.search', [
                'sort_by' => 'date',
                'terms'   => $terms,
            ])" class="font-semibold @if ('date' === $sortBy) text-yellow-500 @else hover:text-yellow-500 @endif">
                most recent
            </a>.
        </p>

        @if ($likes->isNotEmpty())
            <ul class="mt-8">
                @foreach ($likes as $like)
                    <li class="mt-4">
                        <x-tweet :tweet="$like->presenter" />
                    </li>
                @endforeach
            </ul>

            <x-pagination :items="$likes" class="mt-8" />
        @else
            <p class="mt-8 text-center text-gray-500">Sorry, I couldn't find anything matching "{{ $terms }}".</p>
        @endif
    </div>
</x-layouts.full>
