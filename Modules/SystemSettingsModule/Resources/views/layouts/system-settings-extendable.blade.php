@extends('layouts.wrapper')

@section('module-layout-header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/sweetalert2.min.js") }}"></script>
@endsection

@section('side-navigation-menu')

    @if($currentUser->hasAccess(["module.general-settings.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.general-settings.index')}}">
                <span class="{{request()->is('system-settings/general-settings') ? 'default-color' : ''}}">
                   <i class="fa fa-paint-brush"></i>&nbsp;
                    General Settings
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.roles.index"]))
        <li class="side-menu-item">
            <a href="{{ route("module.roles.index") }}">
                <span class="{{request()->is('system-settings/roles') ? 'default-color' : ''}}">
                    <i class="fa fa-shield"></i>&nbsp;
                        Access Rights
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.departments.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.departments.index')}}">
                <span class="{{request()->is('system-settings/departments') ? 'default-color' : ''}}">
                    <i class="fa fa-sitemap"></i>&nbsp;
                        Departments
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.positions.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.positions.index')}}">
                <span class="{{request()->is('system-settings/positions') ? 'default-color' : ''}}">
                    <i class="fa fa-briefcase"></i>&nbsp;
                        Job Positions
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.trainings.index"))
        <li class="side-menu-item">
            <a href="{{route('module.trainings.index')}}">
                <span class="{{request()->is('system-settings/trainings') ? 'default-color' : ''}}">
                    <i class="fa fa-graduation-cap"></i>&nbsp;
                        Trainings
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.job-vacancies.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.job-vacancies.index')}}">
                <span class="{{request()->is('system-settings/job-vacancies') ? 'default-color' : ''}}">
                    <i class="fa fa-briefcase"></i>&nbsp;
                        Job Vacancies
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.official-holidays.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.official-holidays.index')}}">
                <span class="{{request()->is('system-settings/official-holidays') ? 'default-color' : ''}}">
                    <i class="fa fa-calendar-plus-o"></i>&nbsp;
                        Official Holidays
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.api-urls.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.api-urls.index')}}">
                <span class="{{request()->is('system-settings/api-urls') ? 'default-color' : ''}}">
                    <i class="fa fa-tasks"></i>&nbsp;
                        API URLs
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.skill-setting.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.skill-setting.index')}}">
                <span class="{{request()->is('system-settings/skill-setting') ? 'default-color' : ''}}">
                    <i class="fa fa-tasks"></i>&nbsp;
                        Skills
                </span>
            </a>
        </li>
    @endif

@endsection