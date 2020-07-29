<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!--StyleSheets -->
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">
        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <div id="app"></div>
    </body>
    
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    
</html>