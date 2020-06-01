<x-layout>
    <h2 class="font-semibold leading-none text-center text-xl">Followers history</h2>

    @forelse ($diffs as $diffsForDay)
        <div class="bg-gray-700 mt-8 py-4 rounded">
            <h3 class="-mx-2 bg-blue-700 flex items-center font-semibold px-6 py-4 rounded-sm shadow">
                <x:zondicon-calendar class="fill-current h-4 inline mr-3 relative" style="top: -1px" /> {{ Illuminate\Support\Carbon::parse($diffsForDay->date)->isoFormat('LL') }}
            </h3>

            @php
                $additionsForDay = Illuminate\Support\Arr::collapse(json_decode($diffsForDay->additions, true));
                $deletionsForDay = Illuminate\Support\Arr::collapse(json_decode($diffsForDay->deletions, true));
            @endphp

            <div class="mt-4">
                <h4 class="font-semibold px-4">New followers</h4>

                @if (! empty($additionsForDay))
                    <ul class="mt-4">
                        @foreach ($additionsForDay as $addition)
                            <li>
                                <x-user :user="$addition">
                                    <x-slot name="icon">
                                        <x:zondicon-add-solid class="fill-current h-4 mr-4 text-green-500 w-4" />
                                    </x-slot>
                                </x-user>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 px-4 text-gray-500">No new followers this day.</p>
                @endif
            </div>

            <div class="mt-4">
                <h4 class="font-semibold px-4">Unfollowers</h4>

                @if (! empty($deletionsForDay))
                    <ul class="mt-4">
                        @foreach ($deletionsForDay as $deletion)
                            <li>
                                <x-user :user="$deletion">
                                    <x-slot name="icon">
                                        <x:zondicon-minus-solid class="fill-current h-4 mr-4 text-red-500 w-4" />
                                    </x-slot>
                                </x-user>
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
