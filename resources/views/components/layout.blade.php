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
    <body class="bg-orange-100">
        <div id="app">
            {{ $slot }}
        </div>

        <script src="@mix('/js/app.js')"></script>
    </body>
</html>
