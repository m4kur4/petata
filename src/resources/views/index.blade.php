<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!--StyleSheets -->
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}" type="text/css">
        <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js" defer></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>

