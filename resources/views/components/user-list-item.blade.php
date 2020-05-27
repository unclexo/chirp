<a href="https://twitter.com/{{ $user['screen_name'] }}" target="_blank" class="hover:bg-white hover:bg-opacity-10 flex items-center px-4 py-2">
    {{ $icon ?? '' }}

    <img src="{{ $user['profile_image_url_https'] }}" width="48" height="48" class="rounded-full">

    <div class="flex-grow ml-4">
        <p class="leading-none mt-1">{{ $user['name'] }}</p>

        <ul class="flex mt-1 text-gray-500">
            <li>
                <span class="text-gray-400">{{ number_format($user['followers_count']) }}</span>
                <span class="sr-only sm:not-sr-only">@choice('follower|followers', $user['followers_count'])</span>
            </li>

            <li class="mx-2">•</li>

            <li>
                <span class="text-gray-400">{{ number_format($user['friends_count']) }}</span>
                <span class="sr-only sm:not-sr-only">@choice('following|followings', $user['friends_count'])</span>
            </li>
        </ul>

        @if ($user['verified'] || in_array('followed_by', $user['connections']) || $user['following'] || $user['protected'] || in_array('muting', $user['connections']))
            <ul class="flex mt-3 pb-1">
                @if ($user['verified'])
                    <li class="bg-blue-500 font-bold mr-1 px-2 sm:px-3 rounded-sm text-white text-xs uppercase">
                        Verified
                    </li>
                @endif

                @if (in_array('followed_by', $user['connections']))
                    <li class="bg-gray-100 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-xs uppercase">
                        Follows you
                    </li>
                @endif

                @if ($user['following'])
                    <li class="bg-gray-100 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-xs uppercase">
                        Following
                    </li>
                @endif

                @if ($user['protected'])
                    <li class="bg-gray-900 font-bold mr-1 px-2 sm:px-3 rounded-sm text-white text-xs uppercase">
                        Protected
                    </li>
                @endif

                @if (in_array('muting', $user['connections']))
                    <li class="bg-blue-900 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-blue-100 text-xs uppercase">
                        Muting
                    </li>
                @endif
            </ul>
        @endif
    </div>
</a>
