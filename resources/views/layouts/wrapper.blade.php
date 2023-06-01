<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{isset($pageTitle) ? $pageTitle : 'Landmark Solution'}}</title>

     <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{asset("images/favicon.png")}}"/>

    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/datatables.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/jquery-ui.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker.standalone.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/custom.css")}}">

    <link rel="stylesheet" href="{{asset("css/theme.css")}}">

    <link rel="stylesheet" href="{{asset("css/main.css")}}">

    <script src="{{asset("js/jquery-3-3-1.min.js")}}"></script>

    <script src="{{asset("js/jquery-ui.min.js")}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.0/dist/promise.min.js"></script>

    @yield('between_jq_bs')

    <script src="{{asset("js/bootstrap.min.js")}}"></script>

    <script src="{{asset("js/datatables.min.js")}}"></script>
    <script src="{{asset("js/bootstrap-datepicker.min.js")}}"></script>

    {{--<script src="{{ asset("js/fontawesome-all.min.js") }}"></script>--}}

    @yield('module-layout-header-scripts')

    @yield('header-scripts')

</head>
<body class="{{$darkMode == 1 ?' dark-mode' : ''}}">
<div class="spinnerBackground">
    <div class="spinner"></div>
</div>
@include('layouts.top-navigation-bar')

<div id="wrapper">

    @include('layouts.side-navigation-menu')

    <div id="page-content-wrapper">
        <span class="side-menu-toggle d-md-none">&#9776;</span>

        @yield('content')

        @include('layouts.social-links-bottom')

    </div>
</div>

</body>

@yield('module-layout-footer-scripts')

@yield('footer-scripts')
<script>
    $(function () {
        $(".side-menu-toggle").click(function () {
            var sidebar = $("#sidebar-wrapper");
            if (sidebar.hasClass("opened")) {
                sidebar.removeClass("opened");
                sidebar.css("left", "0");
                $("#wrapper").css("padding-left", "0");
            } else {
                sidebar.addClass("opened");
                sidebar.css("left", "250px");
                $("#wrapper").css("padding-left", "200px");
            }
        })
    })

    $('.social-media-button').on('click', function(){
        $('.social-links-bottom').slideToggle('slow');
    });

</script>
</html>
