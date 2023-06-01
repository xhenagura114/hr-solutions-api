@extends('layouts.wrapper')

@section('module-layout-header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/sweetalert2.min.js") }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/dobPicker.min.js')}}"></script>
@endsection

@section('side-navigation-menu')

    @if($currentUser->hasAccess("module.reports.index"))
        <li class="side-menu-item">
            <a href="{{ route('module.reports.index') }}">
                <span class="{{request()->is('reports') ? 'default-color' : ''}}">
                    <i class="fa fa-users"></i>&nbsp;
                    {{ trans("label.employees") }}
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.reports.contracts"))
        <li class="side-menu-item">
            <a href="{{route('module.reports.contracts', ['type' => 'year'])}}">
                <span class="{{request()->is('reports/contracts/year') ? 'default-color' : ''}}">
                    <i class="fa fa-file-text"></i>&nbsp;
                    Contracts end per year
                </span>
            </a>
        </li>

        <li class="side-menu-item">
            <a href="{{route('module.reports.contracts', ['type' => 'month'])}}">
                <span class="{{request()->is('reports/contracts/month') ? 'default-color' : ''}}">
                    <i class="fa fa-file-text"></i>&nbsp;
                    Contracts end per month
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.reports.terminations"))
        <li class="side-menu-item">
            <a href="{{route('module.reports.terminations')}}">
                <span class="{{request()->is('reports/terminations') ? 'default-color' : ''}}">
                    <i class="fa fa-file-excel-o"></i>&nbsp;
                    Terminations
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.reports.leaves"))
        <li class="side-menu-item">
            <a href="{{route('module.reports.leaves')}}">
                <span class="{{request()->is('reports/leaves') ? 'default-color' : ''}}">
                    <i class="fa fa-briefcase"></i>&nbsp;
                    Total leaves
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.reports.trainings"))
        <li class="side-menu-item">
            <a href="{{route('module.reports.trainings')}}">
                <span class="{{request()->is('reports/trainings') ? 'default-color' : ''}}">
                    <i class="fa fa-calendar"></i>&nbsp;
                    Trainings
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.reports.interviews"))
        <li class="side-menu-item">
            <a href="{{route('module.reports.interviews')}}">
                <span class="{{request()->is('reports/interviews') ? 'default-color' : ''}}">
                    <i class="fa fa-edit custom"></i>&nbsp;
                    Interviews
                </span>
            </a>
        </li>
    @endif

{{--    @if($currentUser->hasAccess("module.reports.applicants"))--}}
        <li class="side-menu-item">
            <a href="{{route('module.reports.applicants')}}">
                <span class="{{request()->is('reports/applicants') ? 'default-color' : ''}}">
                    <i class="fa fa-user-plus"></i>&nbsp;
                    Applicants
                </span>
            </a>
        </li>
{{--    @endif--}}


   @if($currentUser->hasAccess("module.reports.partners"))
        <li class="side-menu-item">
            <a href="{{route('module.reports.partners')}}">
                <span class="{{request()->is('reports/partners') ? 'default-color' : ''}}">
                    <i class="fa fa-briefcase"></i>&nbsp;
                    Partners
                </span>
            </a>
        </li>
  @endif

@endsection
