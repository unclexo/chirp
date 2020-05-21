<x-layout>
    <h2 class="font-semibold leading-none text-xl">Followings history</h2>

    @forelse ($diffs as $diff)
        <div class="bg-gray-700 mt-8 py-4 rounded">
            <h3 class="-mx-2 bg-blue-700 font-semibold px-6 py-4 rounded-sm shadow">
                {{ $diff->created_at->isoFormat('LL') }}
            </h3>

            <div class="mt-8">
                <h4 class="font-semibold px-4">New people you subscribed to</h4>

                @if ($diff->additions->isNotEmpty())
                    <ul class="mt-4">
                        @foreach ($diff->additions as $follow)
                            <li>
                                <x-user-list-item :user="$follow">
                                    <x-slot name="icon">
                                        <x:zondicon-add-solid class="fill-current h-4 mr-4 text-green-500 w-4" />
                                    </x-slot>
                                </x-user-list-item>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 px-4 text-gray-500">You didn't subscribe to anyone this day.</p>
                @endif
            </div>

            <div class="mt-8">
                <h4 class="font-semibold px-4">People you unsubscribed from</h4>

                @if ($diff->deletions->isNotEmpty())
                    <ul class="mt-4">
                        @foreach ($diff->deletions as $unfollow)
                            <li>
                                <x-user-list-item :user="$unfollow">
                                    <x-slot name="icon">
                                        <x:zondicon-minus-solid class="fill-current h-4 mr-4 text-red-500 w-4" />
                                    </x-slot>
                                </x-user-list-item>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 px-4 text-gray-500">You didn't unsubscribe from anyone this day.</p>
                @endif
            </div>
        </div>
    @empty
        <p class="bg-gray-700 mt-8 px-4 py-8 rounded text-center text-gray-500">
            Nothing to show yet, please let us gather more data and come back later!
        </p>
    @endforelse
</x-layout>
