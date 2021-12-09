<!doctype html>
<html lang="ru">
<head>
    @php($assets_value = 10)

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Сервис SignDealNow</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css?v={{ $assets_value }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" rel="stylesheet">

    @if(app()->environment('local'))
        <meta name="environment" content="local">
    @endif

</head>
<body>

    <main id="app">
        @yield('content')
    </main>

    <!-- Scripts -->
{{--    <script src="{{ asset('js/account.js') }}" defer></script>--}}
    <script src="/js/@yield('js')?v={{ $assets_value }}"></script>

</body>
</html>
