<div class="header border-bottom sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand " href="#">

            <img class="header-logo" src="{{ (asset($system_settings->logo_path)) }}" alt="Landmark">

        </a>
        <ul class="navbar-nav mr-auto">

            @if($currentUser->hasAccess('system.module.home'))
                <li class="nav-item">
                    <a class="{{if_module_active('home')}} nav-link" href="{{ route('system.module.home') }}">
                        <i class="fa fa-home module-icons"></i>
                        <span class="d-none d-md-block">Home</span>
                    </a>
                </li>
            @endif

            @if($currentUser->hasAccess('module.employee.index'))
                <li class="nav-item {{request()->is('employee') || request()->is('employee/*') || request()->is('applicants') || request()->is('statistics') || request()->is('employee-history') || request()->is('internship') || request()->is('partners') ? 'active' : ''}}">
                    <a class="{{if_module_active('employee-management')}} nav-link"
                       href="{{ route('module.employee.index') }}">
                        <i class="fa fa-user module-icons"></i>
                        <span class="d-none d-md-block">Employees</span>
                    </a>
                </li>
            @endif

            @if($currentUser->hasAccess('module.requests.home'))
                <li class="nav-item {{request()->is('requests') || request()->is('requests/*') ? 'active' : ''}}">
                    <a class="{{if_module_active('requests')}} nav-link"
                       href="{{ route('module.requests.home') }}">
                        <i class="fa fa-flag module-icons"></i>
                        <span class="d-none d-md-block">Requests</span>
                    </a>
                </li>
            @endif

            @if($currentUser->hasAccess('module.file-manager.home'))
                <li class="nav-item {{request()->is('file-manager') ? 'active' : ''}}">
                    <a class="{{if_module_active('file-manager')}} nav-link"
                       href="{{ route('module.file-manager.home') }}">
                        <i class="fa fa-file module-icons"></i>
                        <span class="d-none d-md-block">Files</span>
                    </a>
                </li>
            @endif

            @if($currentUser->hasAccess('module.self-service.home'))
                {{--<li class="nav-item notification">--}}
                <li class="nav-item {{request()->is('self-service/*') ? 'active' : ''}}">
                    <a class="{{if_module_active('self-service')}} nav-link"
                       href="{{ route('module.self-service.home') }}">
                        <i class="fa fa-user module-icons user-self-service"></i>
                        <i class="fa fa-cog self-service"></i>
                        <span class="d-none d-md-block">My Profile</span>
                    </a>
                </li>
            @endif

            @if($currentUser->hasAccess('module.calendar.home'))
                <li class="nav-item {{request()->is('calendar') ? 'active' : ''}}">
                    <a class="{{if_module_active('calendar')}} nav-link"
                       href="{{ route('module.calendar.home') }}">
                        <i class="fa fa-calendar module-icons"></i>
                        <span class="d-none d-md-block">Agenda</span>
                    </a>
                </li>
            @endif

            @if($currentUser->hasAccess('module.system-settings.home'))
                {{--<li class="nav-item notification">--}}
                <li class="nav-item {{request()->is('system-settings/*') ? 'active' : ''}}">
                    <a class="{{if_module_active('system-settings')}} nav-link"
                       href="{{ route('module.system-settings.home') }}">
                        <i class="fa fa-cogs module-icons"></i>
                        <span class="d-none d-md-block">Settings</span>
                    </a>
                </li>
            @endif

            @if($currentUser->hasAccess('module.reports.index'))
                {{--<li class="nav-item notification">--}}
                <li class="nav-item {{request()->is('reports') || request()->is('reports/*') ? 'active' : ''}}">
                    <a class="{{if_module_active('system-settings')}} nav-link"
                       href="{{ route('module.reports.index') }}">
                        <i class="fa fa-file-text module-icons"></i>
                        <span class="d-none d-md-block">Reports</span>
                    </a>
                </li>
            @endif

        </ul>

        @if($currentUser->hasAccess('module.authentication.logout'))
            <div class="my-2 right-menu float-right mr-5">
                @if($currentUser->hasAccess('user.birthday.count'))
                    <a href="{{ route('user.birthday.list') }}">
                        <i class="fa fa-birthday-cake ml-2 right-menu-icon"></i>
                        @if($total_birthdays > 0)
                            <span class="badge badge-danger">{{$total_birthdays}}</span>
                        @endif
                        @if($total_upcoming > 0)
                            <span class="badge badge-warning">{{$total_upcoming}}</span>
                        @endif
                    </a>
                @endif
                    @if($currentUser->hasAccess('user.prehired.count'))
                        <a href="{{ route('user.prehired.list') }}">
                            <i class="fa fa-bell ml-2 right-menu-icon"></i>
                            @if($total_prehired > 0)
                                <span class="badge badge-danger">{{$total_prehired}}</span>
                            @endif
                            @if($prehired_upcoming > 0)
                                <span class="badge badge-warning">{{$prehired_upcoming}}</span>
                            @endif
                        </a>
                    @endif
                <a href="{{ route('module.authentication.logout') }}">
                    <i class="fa fa-sign-out ml-2 right-menu-icon"></i>
                </a>
            </div>
        @endif
    </nav>
</div>
