@extends('employeemanagementmodule::layouts.employees-management-extendable',['pageTitle' => 'Employee Management'])


@section('header-scripts')
    {{--add here additional header scripts--}}

    <link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">

    <link rel="stylesheet" href="{{asset("css/Treant.css")}}">

    <link rel="stylesheet" href="{{asset("css/basic-example.css")}}">

    <script src="{{asset("js/Chart.bundle.min.js")}}"></script>

    <script src="{{asset("js/raphael.js")}}"></script>

    <script src="{{asset("js/Treant.js")}}"></script>

    <script src="{{asset("js/loader.js")}}"></script>


@endsection

@section('content')

    <div class="dashboard statistic">
        <div class="container">
            <div class="row dashboard-four-panels">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="row col-white">
                        <div class="col-md-5 col-sm-5">
                            <h2>{{$new_users_this_month}}</h2>
                            <span>New Employee{{$new_users_this_month == 1 ? '' : 's' }}</span>
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
                            <span>New Applicant{{$applicants == 1 ? '' : 's' }}</span>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <img src="{{asset("images/multi-line-chart.jpg")}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="row col-white">
                        <div class="col-md-5 col-sm-5">
                            <h2>{{$new_trainings_this_month}}</h2>
                            <span>Training{{$new_trainings_this_month == 1 ? '' : 's' }}</span>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <img src="{{asset("images/pie-chart.jpg")}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="row col-white">
                        <div class="col-md-5 col-sm-5">
                            <h2>{{$events_this_month }}</h2>
                            <span>New Event{{$events_this_month == 1 ? '' : 's' }}</span>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <img src="{{asset("images/line-chart.jpg")}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row dashboard-three-panels">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <div class="col-white">
                        <div class="departments">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-6">
                                    <span>Users per Departments</span>
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
                                            @endforeach
                                        ],
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
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <div class="col-white">
                        <span>Absence</span>
                        <canvas id="absence"></canvas>
                        <script>
                            var ctx = document.getElementById("absence").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'horizontalBar',
                                data: {
                                    labels: [
                                        @foreach($departments as $department)
                                            "{!! $department->name !!}",
                                        @endforeach
                                    ],
                                    datasets: [{
                                        label: false,
                                        data: [
                                            @foreach($departments as $department)
                                            {{$department->requests_count}},
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
                                    tooltips: {
                                        // Disable the on-canvas tooltip
                                        enabled: false
                                    },
                                    scales: {
                                        yAxes: [{
                                            barPercentage: 0.2,
                                            ticks: {
                                                beginAtZero: true,
                                                callback: function (value, index, values) {
                                                    return '' + value;
                                                },
                                                min: 0,
                                                suggestedMin: 0,
                                                autoSkip: false,
                                                stepSize: 2
                                            },
                                            gridLines: {
                                                drawOnChartArea: false
                                            }
                                        }],
                                        xAxes: [{
                                            barPercentage: 0.2,
                                            ticks: {
                                                min: 0,
                                                suggestedMin: 0,
                                                autoSkip: false,
                                                stepSize: 2
                                            },
                                            gridLines: {
                                                drawOnChartArea: false
                                            }
                                        }]
                                    },
                                    layout: {
                                        padding: {
                                            left: 0,
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
            <div class="row dashboard-three-panels recruitment">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="col-white">
                        <span>Recent recruitment</span>
                        <table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Date</th>
                                @if($currentUser->hasAccess("module.employee.show"))
                                    <th></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recruitments as $recruitment)
                                <tr>
                                    <td>{{$recruitment->first_name}} {{$recruitment->last_name}}</td>
                                    <td>Landmark Technology</td>
                                    <td>{{$recruitment->created_at? \Carbon\Carbon::parse($recruitment->created_at)->toDateString() : ''}}</td>
                                    @if($currentUser->hasAccess("module.employee.show"))
                                        <td class="text-right"><a id="{{$recruitment->id}}"
                                                                  onclick="editUser({{ $recruitment->id }});"
                                                                  href="javascript:void(0)">View</a></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row calendar dashboard-three-panels vacation-list">
                <div class="col-sm-12 col-md-9 col-lg-9" id="calendarHeight">
                    <div class="col-white">
                        <div class="row">
                            <div class="col-sm-6">
                                <span>Calendar</span>
                            </div>
                            <div class="col-sm-6 text-right">
                                @if($currentUser->hasAccess("module.statistics.birthday-holiday"))
                                    <span id="holidays">Holidays</span>
                                    <span> | </span>
                                    <span id="birthdays">Birthdays</span>
                                @endif
                            </div>
                        </div>

                        <div class="calendarStyles">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>

                @if($currentUser->hasAccess("module.statistics.get-departments-requests"))
                    <div class="col-sm-12 col-md-3 col-lg-3" id="departmentFilter">
                        <div class="col-white">
                            <span>Vacation & Absence</span>
                            <div class="row">
                                @foreach($departments as $department)
                                    <div class="col-md-6 col-sm-12 all-departments" id="{{$department->id}}">
                                        <div class="single-departments"
                                             style="border-top: 5px solid {{$department->color}}">
                                            <h3>{{$department->name}}</h3>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{--Modal--}}
    <div id="userDetail"
         class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body editUserModal">
                </div>
            </div>

        </div>
    </div>

@endsection


@section('footer-scripts')

    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });
    </script>

    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
    <script>

        @if($currentUser->hasAccess("module.employee.show"))
        function editUser(user_id) {
            var url = '{{ route("module.employee.show") }}/' + user_id;

            $.ajax({
                type: "GET",
                url: url,
                dataType: "HTML",
                success: function (data) {
                    $(".editUserModal").empty();
                    $(".editUserModal").html(data);
                    $("#userDetail").modal('show');
                }
            });
        }

        @endif

        jQuery(document).ready(function ($) {
            setTimeout(function () {
                var height = $('#calendarHeight .col-white').height() + 30;
                $('#departmentFilter').css('height', height);
            }, 0);

            var event = {};


            $('#calendarHeight #calendar').fullCalendar({
                header: {
                    left: 'prev, next, today',
                    center: 'title',
                    right: 'month, agendaWeek, agendaDay'
                },
                height: 'auto',
                eventDurationEditable: false,
                defaultDate: '{!! \Carbon\Carbon::now() !!}',
                navLinks: true,
                displayEventTime: false,
                selectable: true,
                unselectAuto: true,
                selectHelper: true,
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                eventBackgroundColor: '#2799fa',
                eventBorderColor: '#2799fa',
                eventTextColor: '#fff',
                eventRender: function (event, element) {
                    if (event.icon) {
                        element.find(".fc-title").append("<i class='fa fa-" + event.icon + "'></i>");
                    }
                },
                events: {!! json_encode($calendar) !!}
            });

            @if($currentUser->hasAccess("module.statistics.get-departments-requests"))

            $(document).on('click', '.single-departments', function () {

                var sweet = swal({
                    text: 'Please wait',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    onOpen: function () {
                        swal.showLoading()
                    }
                });

                var department_id = $(this).parent().attr('id');
                $('.single-departments').css('background-color','transparent');
                $(this).css('background-color', '#f3f3f3');

                /*Start Ajax*/
                var request = $.ajax({
                    url: "{{route('module.statistics.get-departments-requests')}}/" + department_id,
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    dataType: "json"
                });

                request.done(function (data) {
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', data);
                    swal.close();
                });

                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                    swal.close();
                });


            });
            @endif

            @if($currentUser->hasAccess("module.statistics.birthday-holiday"))
            $(document).on('click', '#holidays', function () {
                $('.single-departments').css('background-color','transparent');
                var sweet = swal({
                    text: 'Please wait',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    onOpen: function () {
                        swal.showLoading()
                    }
                });
                /*Start Ajax*/
                var request = $.ajax({
                    url: "{{route('module.statistics.birthday-holiday')}}",
                    method: "GET",
                    data: {
                        type: 'holiday'
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    dataType: "json"
                });

                request.done(function (data) {
                    console.log(data)
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', data);
                    swal.close();
                });

                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                    swal.close();
                });

            });
            @endif

            @if($currentUser->hasAccess("module.statistics.birthday-holiday"))
            $(document).on('click', '#birthdays', function () {
                $('.single-departments').css('background-color','transparent');
                var sweet = swal({
                    text: 'Please wait',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    onOpen: function () {
                        swal.showLoading()
                    }
                });
                /*Start Ajax*/
                var request = $.ajax({
                    url: "{{route('module.statistics.birthday-holiday')}}",
                    method: "GET",
                    data: {
                        type: 'birthday'
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    dataType: "json"
                });

                request.done(function (data) {
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', data);
                    swal.close();
                });

                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                    swal.close();
                });

            });
            @endif

        });

    </script>


@endsection
