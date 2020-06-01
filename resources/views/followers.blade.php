<x-layout>
    <h2 class="font-semibold leading-none text-center text-xl">Followers history</h2>

    @forelse ($diffs as $diff)
        <x-diff
            :diff="$diff"
            additions-title="New followers"
            no-additions-message="No new followers this day."
            deletions-title="Unfollowers"
            no-deletions-message="Good news, nobody unfollowed you this day!"
        />
    @empty
        <p class="bg-gray-700 mt-8 px-4 py-8 rounded text-center text-gray-500">
            Nothing to show yet, please let me gather data and come back later!
        </p>
    @endforelse
</x-layout>
