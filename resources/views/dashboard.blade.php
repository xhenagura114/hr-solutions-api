<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{asset("images/favicon.png")}}"/>

    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/datatables.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/jquery-ui.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/Treant.css")}}">

    <link rel="stylesheet" href="{{asset("css/basic-example.css")}}">

    <link rel="stylesheet" href="{{asset("css/custom.css")}}">

    <link rel="stylesheet" href="{{asset("css/theme.css")}}">

    <link rel="stylesheet" href="{{asset("css/main.css")}}">

    <script src="{{asset("js/jquery-3-3-1.min.js")}}"></script>

    <script src="{{asset("js/jquery-ui.min.js")}}"></script>

    <script src="{{asset("js/bootstrap.min.js")}}"></script>

    <script src="{{asset("js/datatables.min.js")}}"></script>

    <script src="{{asset("js/Chart.bundle.min.js")}}"></script>

    <script src="{{asset("js/raphael.js")}}"></script>

    <script src="{{asset("js/Treant.js")}}"></script>

    <script src="{{asset("js/loader.js")}}"></script>


</head>
<body class="{{visual_settings()->dark_mode == 1 ?' dark-mode' : ''}} dashboard-body">
<div class="spinnerBackground">
    <div class="spinner"></div>
</div>
<div class="dashboard">
    <div class="container">
        <div class="row header">
            <div class="col-md-6 col-sm-6 col-6">
                <i class="fa fa-home"></i>
            </div>
            <div class="col-md-6 col-sm-6 col-6 text-right">
                <a href="{{ route('user.birthday.list') }}">
                    <span class="{{ ($total_birthdays > 0 || $total_upcoming > 0) ? 'has-birthdays' : '' }}">
                        <i class="fa fa-birthday-cake ml-2 right-menu-icon"></i>
                    </span>
                </a>
                <a href="{{ route('module.authentication.logout') }}">
                <i class="fa fa-sign-out ml-2 right-menu-icon"></i>
                </a>
            </div>
        </div>
        <div class="row dashboard-four-panels">
            <div class="col-md-12">
                <h1>Dashboard</h1>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="row col-white">
                    <div class="col-md-5 col-sm-5">
                        <h2>{{$new_users_this_month}}</h2>
                        <span>New Employee{{$new_users_this_month == 1 ? '' : 's'}}</span>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <img src="{{asset("images/line-chart.jpg")}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="row col-white">
                    <div class="col-md-5 col-sm-5">
                        <h2>{{$applicants}}</h2>
                        <span>New Applicant{{$applicants == 1 ? '' : 's'}}</span>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <img src="{{asset("images/multi-line-chart.jpg")}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="row col-white">
                    <div class="col-md-5 col-sm-5">
                        <h2>{{$total_trainings}}</h2>
                        <span>Program Trainings</span>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <canvas id="trainings" width="180" height="63"></canvas>
                        <script>
                            var ctx = document.getElementById("trainings").getContext('2d');
                            var trainingChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: [
                                        'Upcoming Trainings',
                                        'Performed Trainings',
                                        'Ongoing Trainings'
                                    ],
                                    datasets: [{
                                        label: false,
                                        data: [
                                            {{$upcoming_trainings}},
                                            {{$old_trainings}},
                                            {{$trainings_now}}
                                        ],
                                        backgroundColor: [
                                            'rgb(75, 192, 192)',
                                            'rgb(54, 162, 235)',
                                            'rgb(255, 205, 86)'
                                        ]
                                    }]
                                },

                                options: {
                                    layout: {
                                        padding: {
                                            left: 40,
                                            right: 0,
                                            top: 0,
                                            bottom: 0
                                        }
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="row col-white">
                    <div class="col-md-5 col-sm-5">
                        <h2>{{$events_this_month }}</h2>
                        <span>New Event{{$events_this_month == 1 ? '' : 's'}}</span>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <img src="{{asset("images/line-chart.jpg")}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="row dashboard-three-panels">
            <div class="col-lg-4 col-md-12 col-sm-12 equal-height">
                <div class="col-white">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-6">
                            <span>Job Vacancies</span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6 text-right">
                            <a href="{{route('module.job-vacancies.index')}}"><span>View all</span></a>
                        </div>
                    </div>
                    <img class="w-100" src="{{asset('images/hiring_21.jpg')}}" id="myImg1">
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <?php
                $rowStyle = '
                    display: flex;height: 100%;
                    align-items: center;
                    justify-content: center;
                    flex-direction: column;
                    position: relative;';

                $titleStyle = '
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;';
                ?>
                <div class="col-white middle-height" style="{{(count($upcoming_events) > 0) ? '' : 'height: 100%'}}">
                    <div class="departments" style="{{(count($upcoming_events) > 0) ? '' : $rowStyle}}">
                        <div class="row" style="{{(count($upcoming_events) > 0) ? '' : $titleStyle}}">
                            <div class="col-md-6 col-sm-6 col-6">
                                <span>Users per Departments</span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6 text-right">
                                <a href="{{route('module.departments.index')}}"><span>View all</span></a>
                            </div>
                        </div>
                        <canvas id="departments"></canvas>
                        <script>
                            var ctx = document.getElementById("departments").getContext('2d');
                            var departmentsChart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: [
                                        @foreach($departments as $department)
                                            "{!! $department->name !!}",
                                        @endforeach],
                                    datasets: [{
                                        label: false,
                                        data: [
                                            @foreach($departments as $department)
                                            {{$department->users_count}},
                                            @endforeach
                                        ],
                                        backgroundColor: [
                                            @foreach($departments as $department)
                                                "{{$department->color}}",
                                            @endforeach
                                        ]
                                    }]
                                },

                                options: {
                                    layout: {
                                        padding: {
                                            left: 0,
                                            right: 0,
                                            top: 30,
                                            bottom: 0
                                        }
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
                @if (count($upcoming_events) > 0 )
                    <div class="col-white middle-height-2">
                        <div class="upcoming-events">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-6">
                                    <span>Upcoming events</span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-6 text-right">
                                    <a href="{{route('module.calendar.home')}}"><span>View all</span></a>
                                </div>
                            </div>
                            <div id="timeline">
                                <div class='timeline'>
                                    <div class='start'></div>
                                </div>
                                <div class='entries'>
                                    @foreach($upcoming_events as $events)
                                        <a href="{{route('module.calendar.home')}}">
                                            <div class='entry'>
                                                <div class='dot'></div>
                                                <div class='label' style="background-color: {{$events->color}}">
                                                    <div class='time'>
                                                        {!! (date("H:i", strtotime($events->start_date)) === "00:00") && (date("Y-m-d", strtotime($events->start_date . "+1 day")) === date("Y-m-d", strtotime($events->end_date))) ? date("D, M j", strtotime($events->start_date)).' all day' : date(" M j, H:i", strtotime($events->start_date)) . " <br> - <br> " . date("M j, H:i", strtotime($events->end_date)) !!}
                                                    </div>
                                                    <div class='detail'>
                                                        {{$events->title}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 equal-height">
                <div class="col-white">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-6">
                            <span>Organigram Hierarchy</span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6 text-right">
                            <a href="{{route('module.template.hierarchy')}}"><span>View all</span></a>
                        </div>
                    </div>
                    <div class="hierarchy">
                        <img src="{{asset('images/organigrama_vogel.png')}}" class="organigrama_vogel" id="myImg">
                        <!-- The Modal -->
                        <div id="organigrama" class="modal">
                            <span class="close">&times;</span>
                            <iframe src="{{asset('images/organigrama.pdf#view=FitH')}}" class="modal-content"
                                    id="img01"></iframe>
                        </div>
                        <script>
                            // Get the modal
                            var modal = document.getElementById('organigrama');

                            // Get the image and insert it inside the modal - use its "alt" text as a caption
                            var img = document.getElementById('myImg');
                            var modalImg = document.getElementById("img01");
                            var captionText = document.getElementById("caption");
                            img.onclick = function () {
                                modal.style.display = "block";
                            };

                            // Get the <span> element that closes the modal
                            var span = document.getElementsByClassName("close")[0];

                            // When the user clicks on <span> (x), close the modal
                            span.onclick = function () {
                                modal.style.display = "none";
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dashboard-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="dashboard-menu">
                    @if($currentUser->hasAccess("module.employee.index"))
                        <li class="nav-item">
                            <a class="{{if_module_active('employee-management')}} nav-link"
                               href="{{ route('module.employee.index') }}">
                                <i class="fa fa-user module-icons"></i>
                                <span class="d-none d-md-block">Employees</span>
                            </a>
                        </li>
                    @endif

                    @if($currentUser->hasAccess("module.self-service.home"))
                        <li class="nav-item notification">
                            <a class="{{if_module_active('self-service')}} nav-link"
                               href="{{ route('module.self-service.home') }}">
                                <i class="fa fa-user module-icons user-self-service"></i>
                                <i class="fa fa-cog self-service"></i>
                                <span class="d-none d-md-block">My Profile</span>
                            </a>
                        </li>
                    @endif

                    @if($currentUser->hasAccess("module.requests.home"))
                        <li class="nav-item">
                            <a class="{{if_module_active('requests')}} nav-link"
                               href="{{ route('module.requests.home') }}">
                                <i class="fa fa-flag module-icons"></i>
                                <span class="d-none d-md-block">Requests</span>
                            </a>
                        </li>
                    @endif

                    @if($currentUser->hasAccess("module.file-manager.home"))
                        <li class="nav-item">
                            <a class="{{if_module_active('file-manager')}} nav-link"
                               href="{{ route('module.file-manager.home') }}">
                                <i class="fa fa-file module-icons"></i>
                                <span class="d-none d-md-block">Files</span>
                            </a>
                        </li>
                    @endif

                    @if($currentUser->hasAccess("module.calendar.home"))
                        <li class="nav-item">
                            <a class="{{if_module_active('calendar')}} nav-link"
                               href="{{ route('module.calendar.home') }}">
                                <i class="fa fa-calendar module-icons"></i>
                                <span class="d-none d-md-block">Agenda</span>
                            </a>
                        </li>
                    @endif

                    @if($currentUser->hasAccess("module.system-settings.home"))
                        <li class="nav-item notification">
                            <a class="{{if_module_active('system-settings')}} nav-link"
                               href="{{ route('module.system-settings.home') }}">
                                <i class="fa fa-cogs module-icons"></i>
                                <span class="d-none d-md-block">Settings</span>
                            </a>
                        </li>
                    @endif

                    @if($currentUser->hasAccess("module.reports.index"))
                        <li class="nav-item notification">
                            <a class="{{if_module_active('reports')}} nav-link"
                               href="{{ route('module.reports.index') }}">
                                <i class="fa fa-file-text module-icons"></i>
                                <span class="d-none d-md-block">Reports</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(window).bind("load", function () {
        $('.spinnerBackground').fadeOut(500);
    });
</script>
</body>
</html>
