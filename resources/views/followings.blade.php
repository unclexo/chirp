<x-layout>
    <h2 class="font-semibold leading-none text-xl">Followings history</h2>

    @forelse ($diffs as $diffsForDay)
        <div class="bg-gray-700 mt-8 py-4 rounded">
            <h3 class="-mx-2 bg-blue-700 font-semibold px-6 py-4 rounded-sm shadow">
                {{ Illuminate\Support\Carbon::parse($diffsForDay->date)->isoFormat('LL') }}
            </h3>

            @php
                $additionsForDay = json_decode($diffsForDay->additions, true);
                $deletionsForDay = json_decode($diffsForDay->deletions, true);
            @endphp

            <div class="mt-8">
                <h4 class="font-semibold px-4">New people you subscribed to</h4>

                @if ($additionsForDay)
                    <ul class="mt-4">
                        @foreach ($additionsForDay as $additions)
                            @foreach ($additions as $addition)
                                <li>
                                    <x-user-list-item :user="$addition">
                                        <x-slot name="icon">
                                            <x:zondicon-add-solid class="fill-current h-4 mr-4 text-green-500 w-4" />
                                        </x-slot>
                                    </x-user-list-item>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 px-4 text-gray-500">You didn't subscribe to anyone this day.</p>
                @endif
            </div>

            <div class="mt-8">
                <h4 class="font-semibold px-4">People you unsubscribed from</h4>

                 @if ($deletionsForDay)
                    <ul class="mt-4">
                        @foreach ($deletionsForDay as $deletions)
                            @foreach ($deletions as $deletion)
                                <li>
                                    <x-user-list-item :user="$deletion">
                                        <x-slot name="icon">
                                            <x:zondicon-minus-solid class="fill-current h-4 mr-4 text-red-500 w-4" />
                                        </x-slot>
                                    </x-user-list-item>
                                </li>
                            @endforeach
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
