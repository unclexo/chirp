<x-layout>
    <h2 class="font-semibold leading-none text-xl">Settings</h2>

    <h3 class="font-semibold leading-none mt-8">Remove your account</h3>

    <form method="POST" action="@route('user.delete')" class="sm:flex sm:items-center mt-4">
        @csrf
        @method('DELETE')

        <p>
            <strong class="font-normal text-white">All your data will definitely be lost</strong>. You will still be able to come back to @config('app.name') whenever you want.
        </p>

        <button type="submit" class="bg-red-500 hover:bg-red-400 font-semibold inline-block sm:ml-8 mt-4 sm:mt-0 mx-auto px-4 py-2 rounded text-red-100 table sm:inline-block hover:text-white">Supprimer</button>
    </form>
</x-layout>
