@extends('selfservicemodule::layouts.requests-extendable',['pageTitle' => 'Self-Service'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css">
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
    <link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
@endsection


@section('content')
    <?php
    $selectCompany = $company_enum;
    ?>
    <div class="container-fluid">
        <div class="searchBar">
            <p>Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-xl-2 col-lg-3 col-md-4">
                <input type="text" class="form-control hr-input" id="myInputTextField" placeholder="Name">
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4">
                <select class="filters-select-company selectpicker hr-input" id="filter_company"
                        data-live-search="true">
                    <option value="">Company</option>
                    @foreach ($company_enum as $company)
                        <option value="{{$company}}">{{$company}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="hr-content pt-4 pb-4 full-wrapper vacation-requests">
            <div class="h-100 scroll">
                <div class="container-fluid">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-6">
                                    <h5 class="hr-default-text">Pending Requests</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModalLong">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <form action="{{route('module.requests.manual-request')}}" method="POST" enctype="multipart/form-data"
                                      class="modal-dialog"
                                      role="document">
                                    {{ csrf_field() }}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add leave request</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{--<div class="container-fluid">--}}

                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <Label for="user_id" class="hr-default-text label-sm">Select User</Label>
                                                    {{ Form::select('user_id', $all_users->pluck('full_name', 'id'), null, ['placeholder' => 'Select new user', 'class' => 'selectpicker users-requests', ' data-live-search' => 'true', 'required' => 'required']) }}
                                                </div>
                                                <div class="col-md-6">
                                                    {{ Form::label('reason', 'Select Reason', ['class' => 'hr-default-text label-sm ']) }}
                                                    {{Form::select('reason', $reasons, 'VACATIONS', array('class' => 'form-control selectpicker', 'required'=>'required'))}}
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-md-6">
                                                    {{ Form::label('start_date', 'From Date', ['class' => 'hr-default-text label-sm']) }}
                                                    <div class="input-group date" data-provide="datetimepicker"
                                                         id='datetimepicker1'>
                                                        <input type='text' class="form-control" name="start_date"
                                                               placeholder="dd-mm-yyyy" autocomplete="off" required>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar" style="color: #2799fa"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    {{ Form::label('end_date', 'To Date', ['class' => 'hr-default-text label-sm']) }}
                                                    <div class="input-group" data-provide="datetimepicker"
                                                         id='datetimepicker2'>
                                                        <input type='text' class="form-control" name="end_date"
                                                               placeholder="dd-mm-yyyy" autocomplete="off" required>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar" style="color: #2799fa"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-5 mb-5">
                                                <div class="col-md-12">
                                                    <label for=description"
                                                           class="hr-default-text pl-3">Description</label>
                                                    {{ Form::textarea('description', '', array('class' => 'form-control requestDesc', 'placeholder' => 'Enter request description', 'rows' => '4')) }}
                                                </div>
                                            </div>

                                            <div class="row mt-5 mb-5">
                                                <label for="photo_path" class="hr-default-text pl-3">Attach
                                                    report</label>
                                                {{-- <div class="upload-file">
                                                    <input name="file" id="file" type="file">
                                                </div> --}}

                                                <div class="col-md-6">
                                                    <input type="file" name="file" class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-small btn-secondary"
                                                    data-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-small btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Department</th>
                                        <th>Company</th>
                                        <th>Report</th>
                                    </tr>
                                    </thead>
                                    <tbody class="pendingRequest">
                                    @foreach($requests as $request)
                                        @if($request)
                                            <tr id="{{$request['id']}}">
                                                <td>{{$request->user->full_name}}</td>
                                                <td><b><i>{{$request['start_date']}} :: {{$request['end_date']}}</i></b>
                                                    <br>{{$request['working_days']}}
                                                </td>
                                                <td>{{$request['reason']}}</td>
                                                <td>{{$request->user->departments->name}}</td>
                                                <td>{{$request->user->company}}</td>
                                                <td><img src="{{asset('/images/').'/'.$request['photo_path']}}" width="100" height="100"></td>
                                            </tr>

                                        @endif
                                    @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 calendarView">
                            <h5 class="hr-default-text">Approved Requests</h5>
                            <div class="calendarHeight">
                                <div class="calendarStyles">
                                    <div class="row" style="visibility: hidden">
                                        <div class="col-md-6 col-sm-12">
                                            <span class="name"></span>
                                            <span class="dates"></span>
                                        </div>
                                        <div class="col-md-6 col-sm-12 text-right approveVacations">
                                            <button type="button" class="btn btn-success" id="approveVacation" value="">
                                                Approve
                                            </button>
                                            <button type="button" class="btn btn-danger" id="rejectVacation" value="">
                                                Reject
                                            </button>
                                        </div>
                                        <div class="col-md-12 col-sm-12 department-name">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div id='calendar'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <script type='text/javascript'>
        $(document).ready(function () {
            var dateNow = new Date();
            $('#datetimepicker1').datetimepicker({
                defaultDate: moment(dateNow).hours(9).minutes(0).seconds(0).milliseconds(0),
                daysOfWeekDisabled: [0, 6],
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-caret-up",
                    down: "fa fa-caret-down",
                    previous: "fa fa-caret-left",
                    next: "fa fa-caret-right",
                    today: "fa fa-today",
                    clear: "fa fa-clear",
                    close: "fa fa-close"
                },
            });
            $('#datetimepicker2').datetimepicker({
                defaultDate: moment(dateNow).hours(18).minutes(0).seconds(0).milliseconds(0),
                daysOfWeekDisabled: [0, 6],
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-caret-up",
                    down: "fa fa-caret-down",
                    previous: "fa fa-caret-left",
                    next: "fa fa-caret-right",
                    today: "fa fa-today",
                    clear: "fa fa-clear",
                    close: "fa fa-close"
                }
            });
        });
    </script>
    <script type='text/javascript'>
        $(document).ready(function () {

        });
    </script>

    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });
    </script>

    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>

    <script>
        let oDataTable = $('#table').DataTable({
            "bPaginate": false,
            "bSort": false
        });

        $('#myInputTextField').keyup(function () {
            oDataTable.columns(1).search($(this).val()).draw();
        });

        $('#filter_company').change(function () {
            oDataTable.columns(4).search($(this).val()).draw();
        });


        $(document).ready(function () {

            /*Get Height of parent div*/
            function getDivHeight() {
                return $('.calendarView').width();
            }

            $('#calendar').fullCalendar({
                header: {
                    left: 'title',
                    center: '',
                    right: 'prev,next'
                },
                height: getDivHeight() - 100,
                eventDurationEditable: false,
                defaultDate: '{!! \Carbon\Carbon::now() !!}',
                navLinks: true,
                selectable: false,
                unselectAuto: false,
                selectHelper: false,
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                eventBackgroundColor: '#2799fa',
                eventBorderColor: '#2799fa',
                eventTextColor: '#fff',
                events: {!! json_encode($month_requests) !!}
            });

            /*Re-render Calendar with Vacation Request*/
            $(document).on('click', '#table tbody tr', function () {
                if ($(this).find('.dataTables_empty').length > 0) {
                    return;
                } else {
                    var sweet = swal({
                        text: 'Please wait',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false,
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                    if ($('#table tbody tr').hasClass('selected')) {
                        $('#table tbody tr').removeClass('selected');
                    }
                    $(this).addClass('selected');
                    var request_id = $(this).attr('id');

                    /*Load Request to calendar*/
                    var request = $.ajax({
                        url: "{{route('module.requests.edit')}}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        data: {
                            request_id: request_id
                        },
                        dataType: "json"
                    });

                    request.done(function (data) {
                        $('.calendarStyles').find('.row').css('visibility', 'visible');
                        $('#calendar').fullCalendar('removeEvents');
                        // $('#calendar').remove();
                        $('.name').html(data.request.title);
                        $('.dates').html(moment(data.request.start, "YYYY-MM-DD").format('DD/MM/YYYY') + ' - ' + moment(data.request.end, "YYYY-MM-DD").format('DD/MM/YYYY'));
                        $('.department-name span').html(data.request.department);
                        $('#approveVacation').val(request_id);
                        $('#rejectVacation').val(request_id);

                        $('#calendar').fullCalendar('gotoDate', data.request.start);
                        $('#calendar').fullCalendar('addEventSource', data.info.events);
                        swal.close();

                    });

                    request.fail(function (jqXHR, textStatus) {
                        alert("Request failed: " + textStatus);
                        swal.close();
                    });
                }

            });

            /*Approve Vacation Request*/
            $(document).on('click', '#approveVacation', function () {
                var id = $(this).val();
                var request = $.ajax({
                    url: "{{route('module.requests.update')}}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    data: {
                        request_id: id,
                        status: 'APPROVED',
                        reject_description: null
                    },
                    dataType: "json"
                });

                request.done(function (data) {
                    swal({
                        type: 'success',
                        title: 'Your request has been approved',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                });

                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });

            /*Reject Vacation Request*/
            $(document).on('click', '#rejectVacation', function () {
                var id = $(this).val();

                swal({
                    title: 'Add reject reason',
                    type: 'info',
                    html: '<textarea name="addRejectedReason" id="addRejectedReason" class="addEventTitle" placeholder="Enter rejected reason" required>' +
                        '</textarea>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:
                        '<i class="fa fa-floppy-o"></i>&nbsp; Reject',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText:
                        '<i class="fa fa-ban"></i>&nbsp; Cancel',
                    cancelButtonAriaLabel: 'Thumbs down',
                }).then(function (result) {
                    if (result.value) {
                        var reason = $('#addRejectedReason').val();
                        var request = $.ajax({
                            url: "{{route('module.requests.update')}}",
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            data: {
                                request_id: id,
                                status: 'REJECTED',
                                reject_description: reason
                            },
                            dataType: "json"
                        });

                        request.done(function (data) {
                            swal({
                                type: 'error',
                                title: 'Cancelled!',
                                text: 'You cancelled request!',
                                showConfirmButton: false,
                                timer: 1000

                            });

                            setTimeout(function () {
                                location.reload();
                            }, 1000);

                        });

                        request.fail(function (jqXHR, textStatus) {
                            alert("Request failed: " + textStatus);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {

                    }
                });
            });
        });

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

        $("#photo_path").change(function () {
            readURL(this);
        });

    </script>
@endsection
