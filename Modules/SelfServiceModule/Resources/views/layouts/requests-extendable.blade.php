@extends('layouts.wrapper')

@section('module-layout-header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/sweetalert2.min.js") }}"></script>
@endsection

@section('side-navigation-menu')

    @if($currentUser->hasAccess("module.requests.home"))
        <li class="side-menu-item">
            <a href="{{route('module.requests.home')}}">
                <span class="{{request()->is('requests') ? 'default-color' : ''}}">
                    <i class="fa fa-registered"></i>&nbsp;
                       All requests
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.requests.history"))
        <li class="side-menu-item">
            <a href="{{route('module.requests.history')}}">
                <span class="{{request()->is('requests/history') ? 'default-color' : ''}}">
                    <i class="fa fa-history"></i>&nbsp;
                       Requests History
                </span>
            </a>
        </li>
    @endif

@endsection