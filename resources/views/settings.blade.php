<x-layouts.full>
    <h3 class="font-semibold leading-none text-center text-xl">Settings</h3>

    <form method="POST" action="@route('user.delete')" class="mt-8">
        @csrf
        @method('DELETE')

        <h4 class="font-semibold leading-none text-lg">Remove your data</h4>

        <div class="mt-4">
            <p class="leading-loose">
                <strong class="font-semibold">Everything will definitely be lost</strong>, but you will still be able to come back to @config('app.name') whenever you want.
            </p>

            <p class="mt-4 text-center">
                <button type="submit" class="bg-red-500 hover:bg-red-400 font-semibold px-4 py-2 rounded text-red-100 hover:text-yellow-500">Delete</button>
            </p>
        </div>
    </form>
</x-layouts.full>
