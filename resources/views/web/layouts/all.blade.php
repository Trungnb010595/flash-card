<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @yield('title')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/styles.css') }}">
    @yield('css')
</head>
<body>

@yield('header')
@yield('content')
@yield('footer')

<script src="{{asset('web/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>

@yield('script')
</body>
</html>