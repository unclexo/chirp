<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>{{ $title ?? config('app.name') }}</title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        @if (! app()->environment('production'))
            <meta name="robots" content="noindex, nofollow">
        @endif

        <link rel="stylesheet" href="@mix('/css/app.css')">
    </head>
    <body class="bg-gray-900 text-gray-400">
        <a href="https://github.com/sponsors/benjamincrozat" target="_blank" class="bg-green-600 hover:bg-opacity-75 block p-4 text-center">
            <span class="block container">Sponsor @config('app.name')'s developer on GitHub and <strong>get access to the source code</strong> to see how this serverless app works! →</span>
        </a>

        <div class="py-8 md:py-16" style="background-image: linear-gradient(#2e3748, rgba(74, 85, 104, .5))">
            <header class="text-center">
                <h1 class="font-semibold leading-none text-3xl">
                    <a href="@route('home')" class="hover:text-white">
                        @config('app.name')
                    </a>
                </h1>

                <h2 class="leading-none mt-3">Manage your Twitter account for free.</h2>
            </header>

            <div class="container @if (empty($hideSidebar)) md:flex @endif mt-8 md:mt-16">
                @if (empty($hideSidebar))
                    <div class="md:order-2 md:w-1/3">
                        <x-navigation />
                    </div>
                @endif

                <main class="@if (empty($hideSidebar)) mt-8 md:mt-0 md:order-1 md:pr-12 md:w-2/3 @endif">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <footer class="pb-32 pt-8 md:py-8">
            <p class="text-center">
                Made with ❤︎ by <a href="https://twitter.com/benjamincrozat" target="_blank" class="link hover:text-white">Benjamin Crozat</a>.
            </p>
        </footer>

        <script src="@mix('/js/app.js')"></script>

        @stack('body_code')

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-35731537-17"></script>
        <script>window.dataLayer=window.dataLayer || [];function gtag(){dataLayer.push(arguments)};gtag('js', new Date());gtag('config', 'UA-35731537-17')</script>
    </body>
</html>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,900,900i&display=swap">
