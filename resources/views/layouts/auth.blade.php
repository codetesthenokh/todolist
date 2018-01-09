<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
            #registerContainer{
                width: 100%;
                height: 100%;
                position: absolute;
                top:0;
                left: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }
    </style>
    @yield('style')
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</head>
<body>
    <div id="registerContainer">
        @yield('form')
    </div>
</body>
</html>
