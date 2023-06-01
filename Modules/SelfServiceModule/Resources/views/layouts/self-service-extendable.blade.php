@extends('layouts.wrapper')

@section('module-layout-header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/sweetalert2.min.js") }}"></script>

@endsection

@section('side-navigation-menu')

    @if($currentUser->hasAccess("module.self-service.feed"))
        <li class="side-menu-item">
            <a href="{{route('module.self-service.feed')}}">
                <span class="{{request()->is('self-service/feed') ? 'default-color' : ''}}">
                    <i class="fa fa-rss-square"></i>&nbsp;
                    Feed
                </span>
            </a>
        </li>
    @endif
    @if($currentUser->hasAccess("module.self-service.feed-create"))
        <li class="side-menu-item">
            <a href="{{route('module.self-service.feed-create')}}">
                <span class="{{request()->is('self-service/feed-create') ? 'default-color' : ''}}">
                <span class="{{request()->is('self-service/feed/create') ? 'default-color' : ''}}">
                    <i class="fa fa-pencil-square"></i>&nbsp;
                    Post New Feed
                </span>
            </a>
        </li>
    @endif
    @if($currentUser->hasAccess("module.self-service.profile"))
    <li class="side-menu-item">
        <a href="{{route('module.self-service.profile')}}">
            <span class="{{request()->is('self-service/profile') ? 'default-color' : ''}}">
                <i class="fa fa-user-circle"></i>&nbsp;
                Profile
            </span>
        </a>
    </li>
    @endif
    @if($currentUser->hasAccess("module.self-service.requests"))
        <li class="side-menu-item">
            <a href="{{route('module.self-service.requests')}}">
                <span class="{{request()->is('self-service/requests') ? 'default-color' : ''}}">
                    <i class="fa fa-registered"></i>&nbsp;
                       Request Leave
                </span>
            </a>
        </li>
    @endif

@endsection