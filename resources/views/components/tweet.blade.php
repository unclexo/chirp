<div class="bg-gray-700 px-4 py-8 sm:p-8 relative rounded shadow">
    <div class="sm:flex sm:items-center sm:justify-between">
        <a href="{{ $tweet->presenter->userUrl() }}" target="_blank" class="flex items-center sm:pr-4 hover:text-white">
            <img src="{{ $tweet->presenter->avatar() }}" width="48" height="48" class="flex-none rounded-full">

            <div class="leading-tight pl-4">
                <p class="font-bold">{{ $tweet->data->user->name }}</p>
                <p>&#x40;{{ $tweet->data->user->screen_name }}</p>
            </div>
        </a>

        <p class="mt-4 sm:mt-0 sm:pl-4 sm:text-right text-gray-500 text-sm">
            {{ $tweet->presenter->date() }}
        </p>
    </div>

    <p class="hyphens mt-6">
        {!! $tweet->presenter->text() !!}
    </p>

    @if ($tweet->presenter->media()->isNotEmpty())
        <div class="flex mt-6">
            @foreach ($tweet->presenter->media() as $media)
                <a href="{{ $media->url }}" class="@if (! $loop->first) ml-2 @endif flex-grow hover:opacity-75">
                    <img loading="lazy" src="{{ $media->media_url_https }}?name=medium" width="{{ $media->sizes->medium->w }}" height="{{ $media->sizes->medium->h }}" class="h-full object-center object-cover">
                </a>
            @endforeach
        </div>
    @endif

    <p class="mt-8 text-center">
        <a href="{{ $tweet->presenter->url() }}" target="_blank" rel="noopener" class="font-semibold hover:text-white">More on Twitter</a>
    </p>

    <span class="-mx-2 absolute bg-red-500 block mt-2 p-2 right-0 sm:right-auto sm:left-0 rounded-sm shadow-sm top-0"><x:zondicon-heart class="fill-current h-4" /></span>
</div>
