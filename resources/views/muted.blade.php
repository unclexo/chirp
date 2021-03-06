<x-layouts.full>
    <h2 class="font-semibold leading-none text-center text-xl">
        @choice(
            ':formatted muted user|:formatted muted users',
            $user->muted_count,
            ['formatted' => number_format($user->muted_count)]
        )
    </h2>

    <div class="bg-gray-700 mt-8 py-4 rounded">
        @if ($mutedUsers->isNotEmpty())
            <ul>
                @foreach ($mutedUsers as $mutedUser)
                    <li>
                        <x-user :user-object="new App\Presenters\UserPresenter($mutedUser->data)" />
                    </li>
                @endforeach
            </ul>

            <x-pagination :items="$mutedUsers" class="mb-4 mt-8 sm:mx-4" />
        @else
            <p class="my-4 px-4 text-center text-gray-500">You haven't muted anyone yet.</p>
        @endif
    </div>
</x-layouts.full>
