<x-layout>
    <h2 class="font-semibold leading-none text-xl">Likes</h2>

    <div class="mt-8">
        <form method="GET" action="@route('likes')" class="bg-gray-900 flex items-center justify-center rounded-full">
            <input type="search" id="q" name="q" value="{{ old('q') ?? $query }}" placeholder="Search" class="appearance-none bg-transparent flex-grow pl-6 py-3 placeholder-gray-600 w-full">

            <button type="submit" class="bg-blue-500 hover:bg-blue-400 font-bold px-8 py-3 rounded-full text-white">
                Search
            </button>
        </form>

        @if ($likes->isNotEmpty())
            <ul class="mt-8">
                @foreach ($likes as $like)
                    <li class="bg-gray-700 mt-4 px-4 py-8 sm:p-8 relative rounded shadow">
                        <div class="sm:flex sm:items-center sm:justify-between">
                            <a href="{{ $like->presenter->userUrl() }}" target="_blank" class="flex items-center sm:pr-4 hover:text-white">
                                <img src="{{ $like->presenter->avatar() }}" width="48" height="48" class="flex-none rounded-full">

                                <div class="leading-tight pl-4">
                                    <p class="font-bold">{{ $like->data->user->name }}</p>
                                    <p>&#x40;{{ $like->data->user->screen_name }}</p>
                                </div>
                            </a>

                            <p class="mt-4 sm:mt-0 sm:pl-4 sm:text-right text-gray-500 text-sm">
                                {{ $like->presenter->date() }}
                            </p>
                        </div>

                        <p class="hyphens mt-6">
                            {!! $like->presenter->text() !!}
                        </p>

                        @if ($like->presenter->media()->isNotEmpty())
                            <div class="flex mt-4">
                                @foreach ($like->presenter->media() as $media)
                                    <a href="{{ $media->url }}" class="@if (! $loop->first) ml-2 @endif flex-grow hover:opacity-75">
                                        <img loading="lazy" src="{{ $media->media_url_https }}?name=medium" width="{{ $media->sizes->medium->w }}" height="{{ $media->sizes->medium->h }}" class="h-full object-center object-cover">
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <p class="mt-8 text-center">
                            <a href="{{ $like->presenter->url() }}" target="_blank" rel="noopener" class="font-semibold hover:text-white">More on Twitter</a>
                        </p>

                        <span class="-mx-2 absolute bg-red-500 block mt-2 p-2 right-0 sm:right-auto sm:left-0 rounded-sm shadow-sm top-0"><x:zondicon-heart class="fill-current h-4" /></span>
                    </li>
                @endforeach
            </ul>

            <x-pagination :items="$likes" class="mt-8" />
        @else
            @if ($query)
                <p class="mt-8 text-center text-gray-500">Sorry, I couldn't find anything matching "{{ $query }}".</p>
            @else
                <p class="mt-8 text-center text-gray-500">Either you don't have likes yet, or @config('app.name') is still gathering data.</p>
            @endif
        @endif
    </div>
</x-layout>
