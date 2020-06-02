<x-layout>
    <h2 class="font-semibold leading-none text-center text-xl">Likes</h2>

    <div class="mt-8">
        <form method="GET" action="@route('likes')" class="bg-gray-900 flex items-center justify-center rounded-full">
            <input type="hidden" name="sort_by" value="{{ $sortBy }}">

            <label for="q" class="sr-only">Search:</label>

            <input type="search" id="q" name="q" value="{{ old('q') ?? $query }}" placeholder="Type some keywords." class="appearance-none bg-transparent flex-grow pl-6 py-3 placeholder-gray-600 w-full">

            <button type="submit" class="bg-blue-500 hover:bg-blue-400 font-bold px-8 py-3 rounded-full text-white">
                Search
            </button>
        </form>

        @if ($query)
            <p class="mt-8 text-center">
                Sort by <a href="@route('likes', ['q' => $query, 'sort_by' => null])" class="font-semibold @if ($sortBy !== 'id') text-yellow-500 @else hover:text-yellow-500 @endif">relevance</a> or <a href="@route('likes', ['q' => $query, 'sort_by' => 'id'])" class="font-semibold @if ($sortBy === 'id') text-yellow-500 @else hover:text-yellow-500 @endif">most recent</a>.
            </p>
        @endif

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
            @if ($query)
                <p class="mt-8 text-center text-gray-500">Sorry, I couldn't find anything matching "{{ $query }}".</p>
            @else
                <p class="mt-8 text-center text-gray-500">I'm still gathering data… Please come back in a few minutes.</p>
            @endif
        @endif
    </div>
</x-layout>
