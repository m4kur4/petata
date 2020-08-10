<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--StyleSheets -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('_static/css/petata-proto.css') }}">
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">


    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js" defer></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('/image/logo_32.svg') }}" type="image/svg+xml">
  </head>
  <body>
    <div id="app"></div>
  </body>
</html>

