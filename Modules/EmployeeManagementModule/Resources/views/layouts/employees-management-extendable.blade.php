@extends('layouts.wrapper')

@section('module-layout-header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/sweetalert2.min.js") }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/dobPicker.min.js')}}"></script>
@endsection

@section('side-navigation-menu')

    @if($currentUser->hasAccess("module.employee.index"))
        <li class="side-menu-item">
            <a href="{{ route('module.employee.index') }}">
                <span class="{{request()->is('employee') ? 'default-color' : ''}}">
                    <i class="fa fa-user"></i>&nbsp;
                    {{ trans("label.employees") }}
                </span>
                {{--<span class="pull-right">--}}
                    {{--<span class="badge hr-badge mr-2">2</span>--}}
                {{--</span>--}}
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.employee.sisal"))
        <li class="side-menu-item">
            <a href="{{ route('module.employee.sisal') }}">
                <span class="{{request()->is('employee/sisal') ? 'default-color' : ''}}">
                    <i class="fa fa-user"></i>&nbsp;
                    Sisal Employees
                </span>
            </a>
        </li>
    @endif
    
    @if($currentUser->hasAccess(["module.employee.create",  "module.employee.store"]))
        <li class="side-menu-item">
            <a href="{{ route('module.employee.create') }}">
                <span class="{{request()->is('employee/create') ? 'default-color' : ''}}">
                    <i class="fa fa-plus-square"></i>&nbsp;
                    {{ trans("label.add_new") }}
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.employee-history.index"))
        <li class="side-menu-item">
            <a href="{{route('module.employee-history.index')}}">
                <span class="{{request()->is('employee-history') ? 'default-color' : ''}}">
                    <i class="fa fa-history"></i>&nbsp;
                    {{ trans("label.employee_history") }}
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.sisal-employees.sisal-employees"))
        <li class="side-menu-item">
            <a href="{{route('module.sisal-employees.sisal-employee')}}">
                <span class="{{request()->is('sisal-employees') ? 'default-color' : ''}}">
                    <i class="fa fa-history"></i>&nbsp;
                    Bla
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.statistics.index"))
        <li class="side-menu-item">
            <a href="{{route('module.statistics.index')}}">
                <span class="{{request()->is('statistics') ? 'default-color' : ''}}">
                    <i class="fa fa-area-chart"></i>&nbsp;
                    {{ trans("label.statistics") }}
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.applicants.index"))
        <li class="side-menu-item">
            <a href="{{route('module.applicants.index')}}">
                <span class="{{request()->is('applicants') ? 'default-color' : ''}}">
                    <i class="fa fa-user-plus"></i>&nbsp;
                    {{ trans("label.applicants") }}
                </span>
            </a>
        </li>
    @endif
    @if($currentUser->hasAccess("module.interviews.index"))
        <li class="side-menu-item">
            <a href="{{route('module.interviews.index')}}">
                <span class="{{request()->is('interviews') ? 'default-color' : ''}}">
                    <i class="fa fa-street-view custom"></i>&nbsp;
                   Interview
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.pre-hired.index"))
        <li class="side-menu-item">
            <a href="{{route('module.pre-hired.index')}}">
                <span class="{{request()->is('pre-hired') ? 'default-color' : ''}}">
                    <i class="fa fa-street-view custom"></i>&nbsp;
                   Pre-hired
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.internship.index"))
        <li class="side-menu-item">
            <a href="{{route('module.internship.index')}}">
                <span class="{{request()->is('internship') ? 'default-color' : ''}}">
                    <i class="fa fa-graduation-cap"></i>&nbsp;
                    Internship
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess("module.partners.index"))
        <li class="side-menu-item">
            <a href="{{route('module.partners.index')}}">
                <span class="{{request()->is('partners') ? 'default-color' : ''}}">
                    <i class="fa fa-briefcase"></i>&nbsp;
                    Partners
                </span>
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess(["module.skills.index"]))
        <li class="side-menu-item">
            <a href="{{route('module.skills.index')}}">
                <span class="{{request()->is('skills') ? 'default-color' : ''}}">
                    <i class="fa fa-tasks"></i>&nbsp;
                        Skills
                </span>
            </a>
        </li>
    @endif

@endsection