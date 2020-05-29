<x-layout>
    <h3 class="font-semibold leading-none text-xl">Settings</h3>

    <form method="POST" action="@route('user.delete')" class="bg-gray-700 bg-opacity-50 mt-8 px-4 py-8 lg:p-8 rounded shadow">
        @csrf
        @method('DELETE')

        <h4 class="font-semibold leading-none">Remove your data</h4>

        <div class="sm:flex sm:items-center mt-4">
            <p>
                <strong class="font-semibold">Everything will definitely be lost</strong>, but you will still be able to come back to @config('app.name') whenever you want.
            </p>

            <button type="submit" class="bg-red-500 hover:bg-red-400 font-semibold inline-block md:ml-8 lg:ml-16 mt-4 sm:mt-0 mx-auto px-4 py-2 rounded text-red-100 table sm:inline-block hover:text-white">Supprimer</button>
        </div>
    </form>
</x-layout>
