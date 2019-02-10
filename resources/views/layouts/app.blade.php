<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <title>{{ config('app.name', 'user manager') }}</title>
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
        <footer id="footer" class="text-center">
            <p>Copyrigth &copy; 2019 Gedvidas </p>
        </footer>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
