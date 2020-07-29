<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name') }}</title>

    </head>
    <body>
        <div id="app"></div>
    </body>
    
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</html>