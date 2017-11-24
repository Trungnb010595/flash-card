@extends('web.layouts.all')
@section('title')
    <title>Flash Card</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('web/css/home.css') }}">
@endsection

@section('header')

@endsection

@section('content')
    @include('web.popups.popup_login')
@endsection

@section('footer')

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            console.log('aaa');
            $('#login_popup').modal('show');
            console.log($('#login_popup'));
        })
    </script>
@endsection
