<a href="https://twitter.com/{{ $data->data->screen_name }}" target="_blank" class="hover:bg-white hover:bg-opacity-10 flex items-center px-4 py-2">
    {{ $icon ?? '' }}

    <img src="{{ $data->avatar() }}" width="48" height="48" class="rounded-full">

    <div class="flex-grow ml-4">
        <p class="leading-none mt-1">{{ $data->data->name }}</p>

        <ul class="flex mt-1 text-gray-500">
            <li>
                <span class="text-gray-400">{{ $data->followersCount() }}</span>
                <span class="sr-only sm:not-sr-only">@choice('follower|followers', $data->data->followers_count)</span>
            </li>

            <li class="mx-2">•</li>

            <li>
                <span class="text-gray-400">{{ $data->friendsCount() }}</span>
                <span class="sr-only sm:not-sr-only">@choice('following|followings', $data->data->friends_count)</span>
            </li>
        </ul>

        @if ($data->data->verified || in_array('followed_by', $data->data->connections) || $data->data->following || $data->data->protected || in_array('muting', $data->data->connections))
            <ul class="flex mt-3 pb-1">
                @if ($data->data->verified)
                    <li class="bg-blue-500 font-bold mr-1 px-2 sm:px-3 rounded-sm text-white text-xs uppercase">
                        Verified
                    </li>
                @endif

                @if (in_array('followed_by', $data->data->connections))
                    <li class="bg-gray-100 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-xs uppercase">
                        Follows you
                    </li>
                @endif

                @if ($data->data->following)
                    <li class="bg-gray-100 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-xs uppercase">
                        Following
                    </li>
                @endif

                @if ($data->data->protected)
                    <li class="bg-gray-900 font-bold mr-1 px-2 sm:px-3 rounded-sm text-white text-xs uppercase">
                        Protected
                    </li>
                @endif

                @if (in_array('muting', $data->data->connections))
                    <li class="bg-blue-900 font-bold mr-1 px-2 sm:px-3 rounded-sm text-gray-900 text-blue-100 text-xs uppercase">
                        Muting
                    </li>
                @endif
            </ul>
        @endif
    </div>
</a>
