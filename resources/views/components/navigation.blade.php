<nav>
    <h3 class="font-semibold hidden md:block leading-none text-xl">Navigation</h3>

    <button
        type="button"
        id="nav-btn"
        class="-tx-50 bg-blurred bg-gray-600 bg-opacity-75 bottom-0 fixed md:hidden h-16 left-50 mb-8 rounded-full text-center text-gray-900 w-16 z-30"
    >
        <span class="sr-only">Navigation</span>
        <x:zondicon-menu class="nav-btn-menu-icn -mt-1 fill-current h-6 inline" />
        <x:zondicon-close class="nav-btn-close-icn -mt-1 fill-current h-6 hidden inline" />
    </button>

    <div id="nav" class="bottom-0 fixed md:static hidden md:block left-0 md:mt-8 right-0 z-20">
        <ul class="bg-gray-800 md:bg-transparent h-screen tiny:h-90vh xs:h-75vh md:h-auto p-4 pb-32 md:p-0 overflow-y-scroll scrolling-touch">
            @foreach (range(1, 1) as $i)
                <li class="w-full md:w-auto">
                    <a href="@route('overview')" class="flex group items-stretch @if (Route::is('overview')) text-white @else  hover:text-white @endif">
                        <span class="relative rounded w-2 @if (Route::is('overview')) bg-blue-500 @else bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 @endif" style="top: -1px"></span>

                        <span class="ml-4">
                            <span class="flex font-semibold items-center">
                                <x:zondicon-view-tile class="fill-current h-4 relative" style="top: -1px" />
                                <span class="ml-2">Overview</span>
                            </span>

                            <span class="block text-gray-500">Bird's-eye view on your numbers.</span>
                        </span>
                    </a>
                </li>
            @endforeach

            <li class="mt-4 w-full md:w-auto">
                <a href="@route('likes')" class="flex group items-stretch @if (Route::is('likes')) text-white @else  hover:text-white @endif">
                    <span class="relative rounded w-2 @if (Route::is('likes')) bg-blue-500 @else bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 @endif" style="top: -1px"></span>

                    <span class="ml-4">
                        <span class="flex font-semibold items-center">
                            <x:zondicon-heart class="fill-current h-4 relative" style="top: -1px" />
                            <span class="ml-2">Likes</span>
                        </span>

                        <span class="block text-gray-500">Instant search any of the tweets you liked.</span>
                    </span>
                </a>
            </li>

            <li class="mt-4 w-full md:w-auto">
                <a href="@route('followers')" class="flex group items-stretch @if (Route::is('followers')) text-white @else  hover:text-white @endif">
                    <span class="relative rounded w-2 @if (Route::is('followers')) bg-blue-500 @else bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 @endif" style="top: -1px"></span>

                    <span class="ml-4">
                        <span class="flex font-semibold items-center">
                            <x:zondicon-user-group class="fill-current h-4 relative" style="top: -1px" />
                            <span class="ml-2">Followers history</span>
                        </span>

                        <span class="block text-gray-500">See who unfollowed you.</span>
                    </span>
                </a>
            </li>

            <li class="mt-4 w-full md:w-auto">
                <a href="@route('followings')" class="flex group items-stretch @if (Route::is('followings')) text-white @else  hover:text-white @endif">
                    <span class="relative rounded w-2 @if (Route::is('followings')) bg-blue-500 @else bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 @endif" style="top: -1px"></span>

                    <span class="ml-4">
                        <span class="flex font-semibold items-center">
                            <x:zondicon-user-group class="fill-current h-4 relative" style="top: -1px; transform: scaleX(-1)" />

                            <span class="ml-2">Followings history</span>
                        </span>

                        <span class="block text-gray-500">Keep track of who you're following.</span>
                    </span>
                </a>
            </li>

            <li class="mt-4 w-full md:w-auto">
                <a href="@route('muted')" class="flex group items-stretch @if (Route::is('muted')) text-white @else  hover:text-white @endif">
                    <span class="relative rounded w-2 @if (Route::is('muted')) bg-blue-500 @else bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 @endif" style="top: -1px"></span>

                    <span class="ml-4">
                        <span class="flex font-semibold items-center">
                            <x:zondicon-volume-off class="fill-current h-4 relative" style="top: -1px" />
                            <span class="ml-2">Muted accounts</span>
                        </span>

                        <span class="block text-gray-500">Why not unmute some of them?</span>
                    </span>
                </a>
            </li>

            <li class="mt-4 w-full md:w-auto">
                <a href="@route('blocked')" class="flex group items-stretch @if (Route::is('blocked')) text-white @else  hover:text-white @endif">
                    <span class="relative rounded w-2 @if (Route::is('blocked')) bg-blue-500 @else bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 @endif" style="top: -1px"></span>

                    <span class="ml-4">
                        <span class="flex font-semibold items-center">
                            <x:zondicon-block class="fill-current h-4 relative" style="top: -1px" />
                            <span class="ml-2">Blocked accounts</span>
                        </span>

                        <span class="block text-gray-500">See all annoying accounts you blocked.</span>
                    </span>
                </a>
            </li>

            <li class="mt-4 w-full md:w-auto">
                <a href="@route('settings')" class="flex group items-stretch @if (Route::is('settings')) text-white @else  hover:text-white @endif">
                    <span class="relative rounded w-2 @if (Route::is('settings')) bg-blue-500 @else bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 @endif" style="top: -1px"></span>

                    <span class="ml-4">
                        <span class="flex font-semibold items-center">
                            <x:zondicon-cog class="fill-current h-4 relative" style="top: -1px" />
                            <span class="ml-2">Settings</span>
                        </span>

                        <span class="block text-gray-500">Toggle features or remove your account.</span>
                    </span>
                </a>
            </li>

            <li class="mt-4 w-full md:w-auto">
                <form method="POST" action="@route('logout')">
                    @csrf

                    <button type="submit" class="flex group items-stretch hover:text-white w-full">
                        <span class="bg-gray-600 bg-opacity-20 group-hover:bg-opacity-40 duration-200 block rounded w-2"></span>
                        <span class="block font-semibold ml-4">Log out</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<div id="nav-overlay" class="bg-black bg-opacity-50 bottom-0 fixed hidden md:hidden left-0 right-0 top-0 z-10" style="-webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px)"></div>

@push('body_code')
    <script>
        document.getElementById('nav-btn').addEventListener('click', e => {
            e.stopPropagation()

            document.getElementById('nav').classList.toggle('hidden')
            document.getElementById('nav-overlay').classList.toggle('hidden')
            document.querySelector('.nav-btn-menu-icn').classList.toggle('hidden')
            document.querySelector('.nav-btn-close-icn').classList.toggle('hidden')
        })

        document.getElementById('nav').addEventListener('click', e => e.stopPropagation())

        document.getElementById('nav-overlay').addEventListener('click', () => {
            document.getElementById('nav').classList.add('hidden')
            document.getElementById('nav-overlay').classList.add('hidden')
            document.querySelector('.nav-btn-menu-icn').classList.remove('hidden')
            document.querySelector('.nav-btn-close-icn').classList.add('hidden')
        })
    </script>
@endpush
