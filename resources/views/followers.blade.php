<x-layout>
    <h2 class="font-semibold leading-none text-xl">Followers history</h2>

    @forelse($diffs as $diff)
        <div class="bg-gray-700 mt-8 py-4 rounded">
            <h3 class="-mx-2 bg-blue-700 font-semibold px-6 py-4 rounded-sm shadow">
                {{ Illuminate\Support\Carbon::parse($diff->date)->isoFormat('LL') }}
            </h3>

            @php
                $additions = json_decode($diff->additions, true)[0];
                $deletions = json_decode($diff->deletions, true)[0];
            @endphp

            <div class="mt-8">
                <h4 class="font-semibold px-4">New followers</h4>

                @if ($additions && is_array($additions))
                    <ul class="mt-4">
                        @foreach ($additions as $addition)
                            <li>
                                <x-user-list-item :following-badge="true" :user="$addition">
                                    <x-slot name="icon">
                                        <x:zondicon-add-solid class="fill-current h-4 mr-4 text-green-500 w-4" />
                                    </x-slot>
                                </x-user-list-item>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 px-4 text-gray-500">No new followers this day.</p>
                @endif
            </div>

            <div class="mt-8">
                <h4 class="font-semibold px-4">Unfollowers</h4>

                @if ($deletions && is_array($deletions))
                    <ul class="mt-4">
                        @foreach ($deletions as $deletion)
                            <li>
                                <x-user-list-item :following-badge="true" :user="$deletion">
                                    <x-slot name="icon">
                                        <x:zondicon-minus-solid class="fill-current h-4 mr-4 text-red-500 w-4" />
                                    </x-slot>
                                </x-user-list-item>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 px-4 text-gray-500">Good news, nobody unfollowed you this day!</p>
                @endif
            </div>
        </div>
    @empty
        <p class="bg-gray-700 mt-8 px-4 py-8 rounded text-center text-gray-500">
            Nothing to show yet, please let us gather more data and come back later!
        </p>
    @endforelse
</x-layout>
