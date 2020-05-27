<x-layout :hide-sidebar="Auth::guest()">
    @auth
        <div class="mt-16 md:mt-0 sm:flex sm:items-center">
            <div class="flex-none text-center md:text-left">
                <img src="{{ $avatar }}" class="h-24 md:h-32 inline rounded-full">
            </div>

            <div class="sm:ml-6 mt-6 sm:mt-0">
                <h1 class="font-semibold leading-none mb-4 text-3xl text-center md:text-left">{{ $user->name }}</h1>

                @if ($description)
                    <p class="italic my-4">{!! $description !!}</p>
                @endif

                @if ($website['expanded_url'] && $website['display_url'])
                    <p class="flex items-center mt-4">
                        <x:zondicon-globe class="fill-current h-5 mr-3 relative" style="top: -1px" />
                        <a href="{{ $website['expanded_url'] }}" target="_blank" class="font-semibold hover:text-white">{{ $website['display_url'] }}</a>
                    </p>
                @endif

                @if ($user->data->location)
                    <p class="flex items-center mt-2">
                        <x:zondicon-location class="fill-current h-5 mr-3 relative" style="top: -1px" />
                        {{ $user->data->location }}
                    </p>
                @endif

                <p class="flex items-center mt-2">
                    <x:zondicon-calendar class="fill-current h-5 mr-3 relative" style="top: -1px" />                    Created on {{ $createdAt->isoFormat('LL') }}
                </p>
            </div>
        </div>

        <div class="-mx-2 flex flex-wrap mt-12">
            <div class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
                <p class="bg-gray-600 bg-opacity-30 p-4 rounded truncate">@choice('<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>tweet</span>|<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>tweets</span>', 484, ['total' => number_format($user->data->statuses_count)])</p>
            </div>

            <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
                <a href="@route('followers')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">@choice('<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>follower</span>|<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>followers</span>', 484, ['total' => number_format($user->data->followers_count)])</a>
            </p>

            <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
                <a href="@route('followings')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">@choice('<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>following</span>|<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>followings</span>', 933, ['total' => number_format($user->data->friends_count)])</a>
            </p>

            <div class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
                <p class="bg-gray-600 bg-opacity-30 p-4 rounded truncate">@choice('<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>like</span>|<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>likes</span>', 2882, ['total' => number_format($user->data->favourites_count)])</p>
            </div>

            <div class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
                <p class="bg-gray-600 bg-opacity-30 p-4 rounded truncate">
                    <span class="block font-semibold text-2xl sm:text-3xl">{{ number_format($user->data->listed_count) }}</span>
                    <span>listed</span>
                </p>
            </div>

            <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
                <a href="@route('muted')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">
                    @choice('<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>muted account</span>|<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>muted accounts</span>', 33, [
                        'total' => number_format(optional($user->muted)->count())
                    ])
                </a>
            </p>

            <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
                <a href="@route('blocked')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">
                    @choice('<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>blocked account</span>|<span class="block font-semibold text-2xl sm:text-3xl">:total</span> <span>blocked accounts</span>', 33, [
                        'total' => number_format(optional($user->blocked)->count())
                    ])
                </a>
            </p>
        </div>

        <a
            href="https://twitter.com/{{ $user->nickname }}"
            target="_blank"
            class="bg-blue-500 hover:bg-blue-400 font-semibold mt-4 mx-auto px-4 sm:px-8 py-4 rounded table text-center"
        >
            Open your profile on Twitter
        </a>
    @else
        <div class="mt-16 text-center">
            <a href="@route('login')" class="bg-blue-500 hover:bg-blue-400 font-semibold inline-block px-8 py-4 rounded text-blue-100 hover:text-white">
                Sign in with Twitter
            </a>
        </div>
    @endauth
</x-layout>
