@extends('selfservicemodule::layouts.self-service-extendable',['pageTitle' => 'Self-Service'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css">
@endsection


@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-5 pb-5 full-wrapper">

            <div class="container-fluid">
                @if($currentUser->hasAccess(["module.self-service.requests-store", "module.self-service.requests"]))
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pl-4">
                        <h5 class="hr-default-text mb-4">Request Leave</h5>
                    </div>
                    <form action="{{route('module.self-service.requests-store')}}" method="POST" role="document"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row pl-4">
                            <div class="col-lg-3">
                                <div class="row mt-5">
                                    <div class="col">
                                        {{ Form::label('start_date', 'From Date', ['class' => 'hr-default-text label-sm']) }}
                                        <div class="input-group date" data-provide="datetimepicker"
                                             id='datetimepicker3'>
                                            <input type='text' class="form-control" name="start_date"
                                                   placeholder="dd-mm-yyyy" autocomplete="off" required>
                                            <span class="input-group-addon">
                                            <span class="fa fa-calendar" style="color: #2799fa"></span>
                                        </span>
                                        </div>
                                        <span class="d-none text-danger">Not valid date</span>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col">
                                        {{ Form::label('end_date', 'To Date', ['class' => 'hr-default-text label-sm']) }}
                                        <div class="input-group" data-provide="datetimepicker"
                                             id='datetimepicker4'>
                                            <input type='text' class="form-control" name="end_date"
                                                   placeholder="dd-mm-yyyy" autocomplete="off" required>
                                            <span class="input-group-addon">
                                            <span class="fa fa-calendar" style="color: #2799fa"></span>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col">
                                        {{ Form::label('reason', 'Select Reason', ['class' => 'hr-default-text label-sm']) }}
                                        {{Form::select('reason', $reasons, 'VACATIONS', array('class' => 'form-control selectpicker', 'required'=>'required'))}}
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col">
                                        <label for=photo_path" class="hr-default-text label-sm">Attach report</label>
                                        <div class="upload-file">
                                            <input name="photo_path" id="photo_path" type="file">
                                        </div>
                                    </div>
                                </div>

                                <div class="row pl-4 mt-5">
                                    <div class="col">
                                        {{ Form::submit('Add', array('class' => 'btn btn-small btn-primary')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-5 ml-4 mr-4">
                                {{ Form::label('description', 'Request Description', ['class' => 'hr-default-text label-sm']) }}
                                {{ Form::textarea('description', '', array('class' => 'form-control requestDesc', 'placeholder' => 'Enter request description...')) }}
                            </div>
                            <div class="col-lg-5 mt-5 pl-4 request-table">
                                <table class="table text-center">
                                    <thead>
                                    <tr class="text-center">
                                        <th>Request Dates</th>
                                        <th>Number of working days</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($user_requests as $user_request)
                                        <tr>
                                            <td>{{date_format(date_create($user_request->start_date), 'd M Y')}}
                                                - {{date_format(date_create($user_request->end_date), 'd M Y')}}</td>
                                            <td>{{convertTime(calc_working_days($user_request->start_date,$user_request->end_date)* 60)}}</td>
                                            <td class="requestStatus">
                                        <span class="{{($user_request->status == 'APPROVED') ? 'approved' : (($user_request->status =='REJECTED')? 'rejected' : 'onhold') }}">
                                            <i class="{{request_status_icon($user_request->status)}}"></i>
                                        </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                @endif
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
            $('#datetimepicker3').datetimepicker({
                minDate: new Date(),
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
            $('#datetimepicker4').datetimepicker({
                minDate: new Date(),
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
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

    </script>
@endsection
