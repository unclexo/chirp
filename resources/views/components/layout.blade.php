<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>
            @if (! empty($title))
                {{ $title }} — @config('app.name')
            @else
                @config('app.name') — A free Twitter activity tracker
            @endif
        </title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        @if (! app()->environment('production'))
            <meta name="robots" content="noindex, nofollow">
        @endif
        <meta property="og:locale" content="en">
        <meta property="og:site_name" content="Chirp">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:creator" content="@benjamincrozat">
        <meta name="twitter:site" content="@benjamincrozat">
        <meta name="description" content="Chirp is a 100% free web application to manage your Twitter account.">
        <meta property="og:title" content="Chirp — A free Twitter activity tracker">
        <meta property="og:description" content="Chirp is a 100% free tool to manage your Twitter account. Track unfollowers, instant search through tweets you liked, etc.">
        <meta property="og:image" content="">
        <meta name="twitter:title" content="Chirp">
        <meta name="twitter:description" content="Chirp is a 100% free tool to manage your Twitter account. Track unfollowers, instant search through tweets you liked, etc.">
        <meta name="twitter:image" content="">
        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" href="@mix('/css/app.css')">
        <link rel="apple-touch-icon" sizes="180x180" href="@secureAsset('apple-touch-icon.png')">
        <link rel="icon" type="image/png" sizes="32x32" href="@secureAsset('favicon-32x32.png')">
        <link rel="icon" type="image/png" sizes="16x16" href="@secureAsset('favicon-16x16.png')">
        <link rel="manifest" href="@secureAsset('site.webmanifest')">
        <link rel="mask-icon" href="@secureAsset('safari-pinned-tab.svg')" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
    </head>
    <body class="bg-gray-900 text-gray-400">
        <p class="container py-4 text-center">
            <a href="https://github.com/sponsors/benjamincrozat" target="_blank">
                <span class="block container">Sponsor @config('app.name')'s developer on GitHub and <strong>get access to the source code</strong> to see how this serverless app works! →</span>
            </a>
        </p>

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

                <div class="@if (empty($hideSidebar)) md:flex @endif mt-8 md:mt-16">
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
        </div>

        <footer class="container pb-32 pt-8 md:py-8">
            <p class="text-center">
                Made with <x:zondicon-heart class="fill-current h-3 inline" /> by <a href="https://twitter.com/benjamincrozat" target="_blank" class="link hover:text-yellow-500">Benjamin Crozat</a>.
            </p>

            <ul class="flex items-center justify-center mt-4">
                <li>
                    <a href="https://dribbble.com/benjamincrozat" class="hover:text-yellow-500">
                        <svg viewBox="0 0 24 24" class="fill-current h-8"><path d="M13.01 13.188c.617 1.613 1.072 3.273 1.361 4.973-2.232.861-4.635.444-6.428-.955 1.313-2.058 2.989-3.398 5.067-4.018zm-.53-1.286c-.143-.32-.291-.638-.447-.955-1.853.584-4.068.879-6.633.883l-.01.17c0 1.604.576 3.077 1.531 4.223 1.448-2.173 3.306-3.616 5.559-4.321zm-3.462-5.792c-1.698.863-2.969 2.434-3.432 4.325 2.236-.016 4.17-.261 5.791-.737-.686-1.229-1.471-2.426-2.359-3.588zm7.011.663c-1.117-.862-2.511-1.382-4.029-1.382-.561 0-1.102.078-1.621.21.873 1.174 1.648 2.384 2.326 3.625 1.412-.598 2.52-1.417 3.324-2.453zm7.971-1.773v14c0 2.761-2.238 5-5 5h-14c-2.762 0-5-2.239-5-5v-14c0-2.761 2.238-5 5-5h14c2.762 0 5 2.239 5 5zm-4 7c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zm-6.656-1.542c.18.371.348.745.512 1.12 1.439-.248 3.018-.233 4.734.049-.084-1.478-.648-2.827-1.547-3.89-.922 1.149-2.16 2.055-3.699 2.721zm1.045 2.437c.559 1.496.988 3.03 1.279 4.598 1.5-1.005 2.561-2.61 2.854-4.467-1.506-.261-2.883-.307-4.133-.131z"/></svg>

                        <span class="sr-only">Dribbble</span>
                    </a>
                </li>

                <li class="ml-2">
                    <a href="https://github.com/benjamincrozat" class="hover:text-yellow-500">
                        <svg viewBox="0 0 24 24" class="fill-current h-8"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-4.466 19.59c-.405.078-.534-.171-.534-.384v-2.195c0-.747-.262-1.233-.55-1.481 1.782-.198 3.654-.875 3.654-3.947 0-.874-.312-1.588-.823-2.147.082-.202.356-1.016-.079-2.117 0 0-.671-.215-2.198.82-.64-.18-1.324-.267-2.004-.271-.68.003-1.364.091-2.003.269-1.528-1.035-2.2-.82-2.2-.82-.434 1.102-.16 1.915-.077 2.118-.512.56-.824 1.273-.824 2.147 0 3.064 1.867 3.751 3.645 3.954-.229.2-.436.552-.508 1.07-.457.204-1.614.557-2.328-.666 0 0-.423-.768-1.227-.825 0 0-.78-.01-.055.487 0 0 .525.246.889 1.17 0 0 .463 1.428 2.688.944v1.489c0 .211-.129.459-.528.385-3.18-1.057-5.472-4.056-5.472-7.59 0-4.419 3.582-8 8-8s8 3.581 8 8c0 3.533-2.289 6.531-5.466 7.59z"/></svg>

                        <span class="sr-only">GitHub</span>
                    </a>
                </li>

                <li class="ml-2">
                    <a href="https://www.instagram.com/benjamincrozat/" class="hover:text-yellow-500">
                        <svg viewBox="0 0 24 24" class="fill-current h-8"><path d="M8.923 12c0-1.699 1.377-3.076 3.077-3.076s3.078 1.376 3.078 3.076-1.379 3.077-3.078 3.077-3.077-1.378-3.077-3.077zm7.946-.686c.033.225.054.453.054.686 0 2.72-2.204 4.923-4.922 4.923s-4.923-2.204-4.923-4.923c0-.233.021-.461.054-.686.031-.221.075-.437.134-.647h-1.266v6.719c0 .339.275.614.616.614h10.769c.34 0 .615-.275.615-.615v-6.719h-1.265c.058.211.102.427.134.648zm.515-5.314h-1.449c-.341 0-.615.275-.615.615v1.45c0 .34.274.616.615.616h1.449c.34 0 .616-.276.616-.616v-1.45c0-.34-.275-.615-.616-.615zm6.616-1v14c0 2.761-2.238 5-5 5h-14c-2.761 0-5-2.239-5-5v-14c0-2.761 2.239-5 5-5h14c2.762 0 5 2.239 5 5zm-4 .846c0-1.019-.826-1.846-1.846-1.846h-12.308c-1.019 0-1.846.827-1.846 1.846v12.307c0 1.02.827 1.847 1.846 1.847h12.309c1.019 0 1.845-.827 1.845-1.847v-12.307z"/></svg>

                        <span class="sr-only">Instagram</span>
                    </a>
                </li>

                <li class="ml-2">
                    <a href="https://linkedin.com/in/benjamincrozat" class="hover:text-yellow-500">
                        <svg viewBox="0 0 24 24" class="fill-current h-8"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>

                        <span class="sr-only">LinkedIn</span>
                    </a>
                </li>

                <li class="ml-2">
                    <a href="https://medium.com/@benjamincrozat" class="hover:text-yellow-500">
                        <svg viewBox="0 0 24 24" class="fill-current h-8"><path d="M19 24h-14c-2.761 0-5-2.239-5-5v-14c0-2.761 2.239-5 5-5h14c2.762 0 5 2.239 5 5v14c0 2.761-2.237 4.999-5 5zm.97-5.649v-.269l-1.247-1.224c-.11-.084-.165-.222-.142-.359v-8.998c-.023-.137.032-.275.142-.359l1.277-1.224v-.269h-4.422l-3.152 7.863-3.586-7.863h-4.638v.269l1.494 1.799c.146.133.221.327.201.523v7.072c.044.255-.037.516-.216.702l-1.681 2.038v.269h4.766v-.269l-1.681-2.038c-.181-.186-.266-.445-.232-.702v-6.116l4.183 9.125h.486l3.593-9.125v7.273c0 .194 0 .232-.127.359l-1.292 1.254v.269h6.274z"/></svg>

                        <span class="sr-only">Medium</span>
                    </a>
                </li>

                <li class="ml-2">
                    <a href="https://twitter.com/benjamincrozat" class="hover:text-yellow-500">
                        <svg viewBox="0 0 24 24" class="fill-current h-8"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-.139 9.237c.209 4.617-3.234 9.765-9.33 9.765-1.854 0-3.579-.543-5.032-1.475 1.742.205 3.48-.278 4.86-1.359-1.437-.027-2.649-.976-3.066-2.28.515.098 1.021.069 1.482-.056-1.579-.317-2.668-1.739-2.633-3.26.442.246.949.394 1.486.411-1.461-.977-1.875-2.907-1.016-4.383 1.619 1.986 4.038 3.293 6.766 3.43-.479-2.053 1.08-4.03 3.199-4.03.943 0 1.797.398 2.395 1.037.748-.147 1.451-.42 2.086-.796-.246.767-.766 1.41-1.443 1.816.664-.08 1.297-.256 1.885-.517-.439.656-.996 1.234-1.639 1.697z"/></svg>

                        <span class="sr-only">Twitter</span>
                    </a>
                </li>
            </ul>
        </footer>

        <script src="@mix('/js/app.js')"></script>

        @stack('body_code')

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-35731537-17"></script>
        <script>window.dataLayer=window.dataLayer || [];function gtag(){dataLayer.push(arguments)};gtag('js', new Date());gtag('config', 'UA-35731537-17')</script>
    </body>
</html>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,900,900i&display=swap">
