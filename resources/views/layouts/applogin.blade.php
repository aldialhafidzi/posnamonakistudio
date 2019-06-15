<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hijrah Mandiri Aplikasi</title>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style-gua.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/glyphicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style-que.css') }}">
    <link rel="shortcut icon" href="{{ URL::asset('images/qstitle.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ URL::asset('css/jquerysctipttop.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/notify.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/prettify.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<script src="{{ URL::asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ URL::asset('js/popper.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/script.js') }}"></script>
<script src="{{ URL::asset('js/notify.js') }}"></script>
<script src="{{ URL::asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>

</html>
