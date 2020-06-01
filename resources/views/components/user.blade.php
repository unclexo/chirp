<a href="https://twitter.com/{{ $user->data->screen_name }}" target="_blank" class="hover:bg-white hover:bg-opacity-10 flex items-center px-4 py-2">
    {{ $icon ?? '' }}

    <img src="{{ $user->avatar() }}" width="48" height="48" class="rounded-full">

    <div class="flex-grow ml-4">
        <p class="leading-none mt-1">{{ $user->data->name }}</p>

        <ul class="flex mt-1 text-gray-500">
            <li>
                <span class="text-gray-400">{{ $user->followersCount() }}</span>
                <span class="sr-only sm:not-sr-only">@choice('follower|followers', $user->data->followers_count)</span>
            </li>

            <li class="mx-2">•</li>

            <li>
                <span class="text-gray-400">{{ $user->friendsCount() }}</span>
                <span class="sr-only sm:not-sr-only">@choice('following|followings', $user->data->friends_count)</span>
            </li>
        </ul>

        @if ($user->data->verified || in_array('followed_by', $user->data->connections) || $user->data->following || $user->data->protected || in_array('muting', $user->data->connections))
            <ul class="flex mt-3 pb-1">
                @if ($user->data->verified)
                    <li class="bg-blue-500 font-bold mr-1 px-2 sm:px-3 rounded-sm text-white text-xs uppercase">
                        Verified
                    </li>
                @endif

                @if (in_array('followed_by', $user->data->connections))
                    <li class="bg-gray-100 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-xs uppercase">
                        Follows you
                    </li>
                @endif

                @if ($user->data->following)
                    <li class="bg-gray-100 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-xs uppercase">
                        Following
                    </li>
                @endif

                @if ($user->data->protected)
                    <li class="bg-gray-900 font-bold mr-1 px-2 sm:px-3 rounded-sm text-white text-xs uppercase">
                        Protected
                    </li>
                @endif

                @if (in_array('muting', $user->data->connections))
                    <li class="bg-blue-900 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-blue-100 text-xs uppercase">
                        Muting
                    </li>
                @endif
            </ul>
        @endif
    </div>
</a>
