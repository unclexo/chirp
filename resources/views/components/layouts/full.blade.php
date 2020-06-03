<x-layouts.base>
    <div class="py-8 md:py-16" style="background-image: linear-gradient(#2e3748, rgba(74, 85, 104, .5))">
        <div class="container">
            <a href="@route('home')">
                <header class="flex items-center justify-center">
                    <img src="@secureAsset('img/icon.png')" class="h-20 relative rounded-full" style="top: -.1rem">

                    <div class="pl-6">
                        <h1 class="font-semibold leading-none text-3xl text-white">
                            @config('app.name')
                        </h1>

                        <h2 class="mt-1 text-yellow-400">A free Twitter activity tracker</h2>
                    </div>
                </header>
            </a>

            <div class="md:flex mt-8 md:mt-16">
                <div class="md:order-2 md:w-1/3">
                    <x-navigation />
                </div>

                <main class="mt-8 md:mt-0 md:order-1 md:pr-12 md:w-2/3">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</x-layouts.base>
