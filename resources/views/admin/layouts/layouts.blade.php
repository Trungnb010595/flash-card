<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{url('/themes/libs/font-awesome-4.7.0/css/font-awesome.css')}}">
    {{--<link rel="stylesheet" href="{{url('/themes/admin/lib/weather-icons/css/weather-icons.css')}}">--}}
    <link rel="stylesheet" href="{{url('/themes/admin/lib/jquery-toggles/toggles-full.css')}}">
    <link rel="stylesheet"
          href="{{url('/themes/admin/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('/themes/admin/lib/select2/select2.css')}}">
    <style>
        .select2-dropdown {
            z-index: 2000 !important;
        }

        .selected-date a {
            background-color: darkorange !important;
            color: white !important;
            font-weight: bold !important;
        }
    </style>
    <link rel="stylesheet" href="{!! url('/themes/admin/lib/jquery-ui/jquery-ui.css') !!}">
    <link rel="stylesheet" href="{!! url('/themes/admin/css/quirk.css') !!}">
    <link rel="stylesheet" href="{{ url('/themes/admin/css/style.css') }}">

    @yield('css')

    {{--<script src="/themes/admin/lib/modernizr/modernizr.js"></script>
    <script src="../lib/html5shiv/html5shiv.js"></script>
    <script src="../lib/respond/respond.src.js"></script>--}}
    <script src="{{url('/themes/admin/js/jquery-3.2.1.min.js')}}"></script>
    <![endif]-->
</head>

<body>
<header>
    <div class="headerpanel">

        <div class="logopanel">
            <h2><a href="{{route('admin.index')}}">Home</a></h2>
        </div>

        <div class="headerbar">
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            <div class="searchpanel">
                <div class="btn-group">
                    {{--<ul class="dropdown-menu pull-left">
                        @foreach(allLanguages() as $key => $value)
                            <li><a href="{{route('admin.language', ['language' => $key])}}"><img
                                            src="/themes/img/{{$key.'.png'}}"/> {{$value['name']}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn min-width-120" data-toggle="dropdown" aria-expanded="true"
                            style="margin-top: 12px; text-align: left">
                        {{languageNameByCode(App::getLocale())}}
                        <span class="caret"></span>
                    </button>--}}
                </div>
            </div>
            <div class="header-right">
                <ul class="headermenu">
                    @if(user())
                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-logged" data-toggle="dropdown">
                                {{user()->name}}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('admin.logout') }}"><i class="glyphicon glyphicon-log-out"></i>
                                        Log Out</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                </ul>
            </div><!-- header-right -->
        </div><!-- headerbar -->
    </div><!-- header-->
</header>

<section>
    @include('admin._menu_left')
    <div class="mainpanel">
        <div class="contentpanel">
            @include('flash::message')
            @yield('content')
        </div><!-- mainpanel -->
    </div>
</section>

<script src="{{url('/themes/admin/lib/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{url('/themes/admin/lib/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{url('/themes/admin/lib/jquery-toggles/toggles.js')}}"></script>
<script src="{{url('/themes/admin/lib/datatables/jquery.dataTables.js')}}"></script>
{{--<script src="{{url('/themes/js/momentjs/moment.min.js')}}"></script>--}}
<script src="{{url('/themes/admin/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js')}}"></script>
<script src="{{url('/themes/admin/lib/select2/select2.js')}}"></script>
<script src="{{url('/themes/admin/js/quirk.js')}}"></script>
{{--<script src="{{url('/themes/admin/js/form.multi-langs.js')}}"></script>--}}
{{--<script src="{{url('/js/common.js')}}"></script>--}}
<script src="{{url('/libs/jstz/jstz.min.js')}}"></script>

<script>
    $(".select5").select2({minimumResultsForSearch: Infinity});
    $(".select5").select2({minimumResultsForSearch: Infinity});
</script>
<script>
    function confirmDelete(e) {
        return confirm("Bạn có thực sự muốn xóa?");
    }
</script>

@yield('script')
</body>
</html>
