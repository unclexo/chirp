<x-layouts.full>
    <h2 class="font-semibold leading-none text-center text-xl">Followings history</h2>

    @forelse ($diffs as $diff)
        <x-diff
            :diff="$diff"
            additions-title="New people you subscribed to"
            no-additions-message="You didn't subscribe to anyone this day."
            deletions-title="People you unsubscribed from"
            no-deletions-message="You didn't unsubscribe from anyone this day."
        />
    @empty
        <p class="bg-gray-700 mt-8 px-4 py-8 rounded text-center text-gray-500">
            Nothing to show yet, please let me gather data and come back later!
        </p>
    @endforelse
</x-layouts.full>
