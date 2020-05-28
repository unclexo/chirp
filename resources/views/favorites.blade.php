<x-layout>
    <h2 class="font-semibold leading-none text-xl">Favorites</h2>

    <div class="mt-8">
        <form method="GET" action="@route('favorites')" class="bg-gray-900 flex items-center justify-center rounded-full">
            <input type="search" id="q" name="q" value="{{ old('q') ?? $q }}" placeholder="Brexit, Game of Thrones, etc." class="bg-transparent flex-grow pl-6 py-3 placeholder-gray-600 w-full">

            <button type="submit" class="bg-blue-500 hover:bg-blue-400 font-bold px-8 py-3 rounded-full text-white">
                Search
            </button>
        </form>

        @if ($favorites->isNotEmpty())
            <ul class="mt-8">
                @foreach ($favorites as $favorite)
                    <li class="bg-gray-700 mt-4 px-4 py-8 sm:p-8 rounded shadow">
                        <div class="flex sm:items-baseline justify-between">
                            <p class='pr-4'>
                                <span class="block font-bold">{{ $favorite->data->user->name }}</span>
                                <span class="block">&#x40;{{ $favorite->data->user->screen_name }}</span>
                            </p>

                            <p class="pl-4 text-gray-500 text-right text-sm">
                                {{ Illuminate\Support\Carbon::parse($favorite->data->created_at)->isoFormat('LL') }}
                            </p>
                        </div>

                        <p class="leading-loose mt-4">{!! $favorite->data->text !!}</p>
                    </li>
                @endforeach
            </ul>

            <x-pagination :items="$favorites" class="mt-8" />
        @else
            @if ($q)
                <p class="mt-8 text-center text-gray-500">Sorry, I couldn't find anything matching "{{ $q }}".</p>
            @else
                <p class="mt-8 text-center text-gray-500">Either you don't have favorites yet, or @config('app.name') is still gathering data.</p>
            @endif
        @endif
    </div>
</x-layout>
