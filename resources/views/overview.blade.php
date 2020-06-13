<x-layouts.full>
    <div class="mt-16 md:mt-0 sm:flex sm:items-center">
        <div class="flex-none text-center md:text-left">
            <img src="{{ $user->presenter->avatar(true) }}" class="h-24 md:h-32 inline rounded-full">
        </div>

        <div class="sm:ml-6 mt-6 sm:mt-0">
            <h1 class="font-semibold leading-none mb-4 text-3xl text-center md:text-left">{{ $user->name }}</h1>

            @if ($description = $user->presenter->description())
                <p class="italic my-4">{!! $description !!}</p>
            @endif

            <p class="flex items-center mt-4">
                <x:zondicon-globe class="fill-current h-5 mr-3 relative" style="top: -1px" />

                <a
                    href="{{ $user->presenter->websiteUrl() }}"
                    target="_blank"
                    class="font-semibold hover:text-yellow-500"
                >
                    {{ $user->presenter->websiteDisplayUrl() }}
                </a>
            </p>

            @if ($user->data->location)
                <p class="flex items-center mt-2">
                    <x:zondicon-location class="fill-current h-5 mr-3 relative" style="top: -1px" />
                    {{ $user->data->location }}
                </p>
            @endif

            <p class="flex items-center mt-2">
                <x:zondicon-calendar class="fill-current h-5 mr-3 relative" style="top: -1px" />
                Since {{ $user->presenter->date() }}
            </p>
        </div>
    </div>

    <div class="-mx-2 flex flex-wrap mt-12">
        <div class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
            <p class="bg-gray-600 bg-opacity-30 p-4 rounded truncate">
                <span class="block font-semibold text-2xl sm:text-3xl">{{ $user->presenter->statusesCount() }}</span>
                @choice('tweet|tweets', $user->presenter->statusesCount())
            </p>
        </div>

        <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
            <a href="@route('followers')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">
                <span class="block font-semibold text-2xl sm:text-3xl">{{ $user->presenter->followersCount() }}</span>
                @choice('follower|followers', $user->data->followers_count)
            </a>
        </p>

        <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
            <a href="@route('followings')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">
                <span class="block font-semibold text-2xl sm:text-3xl">{{ $user->presenter->friendsCount() }}</span>
                @choice('following|followings', $user->data->friends_count)
            </a>
        </p>

        <div class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
            <a href="@route('likes.index')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">
                <span class="block font-semibold text-2xl sm:text-3xl">{{ $user->presenter->favouritesCount() }}</span>
                @choice('like|likes', $user->data->favourites_count)
            </a>
        </div>

        <div class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
            <p class="bg-gray-600 bg-opacity-30 p-4 rounded truncate">
                <span class="block font-semibold text-2xl sm:text-3xl">{{ $user->presenter->listedCount() }}</span>
                listed
            </p>
        </div>

        <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
            <a href="@route('muted')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">
                <span class="block font-semibold text-2xl sm:text-3xl">{{ $user->muted->count() }}</span>
                @choice('muted user|muted users', $user->muted->count())
            </a>
        </p>

        <p class="mb-4 px-2 text-center w-1/2 sm:w-1/3">
            <a href="@route('blocked')" class="bg-gray-600 bg-opacity-30 hover:bg-opacity-50 block p-4 rounded truncate">
                <span class="block font-semibold text-2xl sm:text-3xl">{{ $user->blocked->count() }}</span>
                @choice('blocked user|blocked users', $user->blocked->count())
            </a>
        </p>
    </div>
</x-layouts.full>
