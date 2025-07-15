<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        @vite(['resources/scss/app.scss', 'resources/ts/app.ts'])
    </head>
    <body>
        @yield('body')
    </body>
</html>
