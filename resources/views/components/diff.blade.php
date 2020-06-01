<div class="bg-gray-700 mt-8 py-4 rounded">
    <h3 class="-mx-2 bg-blue-700 flex items-center font-semibold px-6 py-4 rounded-sm shadow">
        <x:zondicon-calendar class="fill-current h-4 inline mr-3 relative" style="top: -1px" /> {{ $diff->date() }}
    </h3>

    <div class="mt-4">
        <h4 class="font-semibold px-4">{{ $additionsTitle }}</h4>

        @if (! empty($diff->additions()))
            <ul class="mt-4">
                @foreach ($diff->additions() as $addition)
                    <li>
                        <x-user :user="new App\Presenters\UserPresenter((object) $addition)">
                            <x-slot name="icon">
                                <x:zondicon-add-solid class="fill-current h-4 mr-4 text-green-500 w-4" />
                            </x-slot>
                        </x-user>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-4 px-4 text-gray-500">{{ $noAdditionsMessage }}</p>
        @endif
    </div>

    <div class="mt-4">
        <h4 class="font-semibold px-4">{{ $deletionsTitle }}</h4>

        @if (! empty($diff->deletions()))
            <ul class="mt-4">
                @foreach ($diff->deletions() as $deletion)
                    <li>
                        <x-user :user="new App\Presenters\UserPresenter((object) $deletion)">
                            <x-slot name="icon">
                                <x:zondicon-minus-solid class="fill-current h-4 mr-4 text-red-500 w-4" />
                            </x-slot>
                        </x-user>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-4 px-4 text-gray-500">{{ $noDeletionsMessage }}</p>
        @endif
    </div>
</div>
