<x-layouts.full>
    <h2 class="font-semibold leading-none text-center text-xl">Likes</h2>

    <div class="mt-8">
        <form method="GET" action="@route('likes.search')" class="bg-gray-900 flex items-center justify-center rounded-full">
            <label for="terms" class="sr-only">Search:</label>

            <input type="search" id="terms" name="terms" placeholder="Type some keywords." class="appearance-none bg-transparent flex-grow pl-6 py-3 placeholder-gray-600 w-full">

            <button type="submit" class="bg-blue-500 hover:bg-blue-400 font-bold px-8 py-3 rounded-full text-white">
                Search
            </button>
        </form>

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
            <p class="mt-8 text-center text-gray-500">I'm still gathering data… Please come back in a few minutes.</p>
        @endif
    </div>
</x-layouts.full>
