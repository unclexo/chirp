<x-layouts.base :hide-sidebar="true">
    <div class="flex items-center justify-center py-8 md:py-16 text-center" style="background-image: linear-gradient(#2e3748, rgba(74, 85, 104, .5))" >
        <div class="container">
            <img src="@secureAsset('img/icon.png')" class="h-24 md:h-32 inline rounded-full">

            <div class="leading-none mt-6">
                <h1 class="text-2xl md:text-3xl"><span class="text-gray-500">Meet</span> <strong class="text-white">@config('app.name')</strong></h1>
                <h2 class="mt-2 md:text-xl text-yellow-500">A free Twitter activity tracker</h2>
            </div>

            <p class="mt-16 md:text-xl">
                To get started,<br>
                <a href="@route('login')" class="font-semibold text-blue-500 hover:text-blue-400">sign&nbsp;in&nbsp;with&nbsp;Twitter</a>.
            </p>
        </div>
    </div>
</x-layouts.base>
