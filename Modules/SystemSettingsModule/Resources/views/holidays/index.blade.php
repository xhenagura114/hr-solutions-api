@if($currentUser->hasAccess('module.official-holidays.index'))
    @extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">

@endsection


@section('content')

    <div class="container-fluid">
        <div class="searchBar">
            <p class="mb-0">Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <input type="text" class="form-control hr-input" id="myInputTextField">
            </div>
        </div>
        <div class="hr-content pt-5 pb-5">
            <div class="h-100 scroll">
                <div class="container-fluid">

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
                    <div class="row mb-4">
                        <div class="col">
                            <h5 class="hr-default-text mb-4">Holidays</h5>
                        </div>
                    </div>

                    @if($currentUser->hasAccess(["module.official-holidays.store"]))
                        {{ Form::open([ 'route' => ['module.official-holidays.store'] ]) }}
                        <div class="row mt-5 mb-5 store-item">
                            <div class="col-lg-3 col-md-12 align-self-center">
                                {{ Form::label('title', 'Holiday Title', ['class'=>'label-sm hr-default-text']) }}
                                {{ Form::text('title', '', array('class' => 'form-control', 'required'=>'required')) }}
                            </div>

                            <div class="col-lg-6 col-md-12 align-self-center">
                                <div class="col-md-6">
                                    {{ Form::label('start_date', 'Select Date', ['class' => 'hr-default-text label-sm']) }}
                                    <div class="input-group date date_start_date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" id="day"
                                               name="day"
                                               placeholder="dd-mm-yyyy" required>
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 align-self-end">
                                <input type="hidden" name="month_day" value=""/>
                                {{ Form::submit('Create', array('class' => 'btn btn-small btn-primary align-self-center pull-right')) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    @endif

                    <div class="row holidays-table">
                        <div class="col">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Holiday</th>
                                    <th>Date</th>
                                    @if($currentUser->hasAnyAccess(["module.official-holidays.edit", "module.official-holidays.update", "module.official-holidays.destroy"]))
                                        <th>Operations</th>
                                    @endif
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($holidays as $holiday)
                                    <tr>
                                        <td class="table-holiday-title">{{$holiday->title}}</td>
                                        <td class="table-holiday-date">{{date('d F, Y (l)',strtotime($holiday->day))}}</td>

                                        @if($currentUser->hasAnyAccess(["module.official-holidays.edit", "module.official-holidays.update", "module.official-holidays.destroy"]))
                                            <td>
                                                @if($currentUser->hasAccess(["module.official-holidays.destroy"]))
                                                    {!! Form::button('<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['class' => 'btn pull-right hr-outline btn-sm delete', 'type' => 'button', 'id' => $holiday->id]) !!}
                                                @endif

                                                @if($currentUser->hasAccess(["module.official-holidays.edit", "module.official-holidays.update"]))
                                                    <a href="{{ route('module.official-holidays.edit' ,[$holiday->id]) }}"
                                                       class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;"
                                                       data-toggle="modal" data-target="#holidayEdit"
                                                       onclick="editHoliday('{{ $holiday->id }}', this )"><i
                                                                class="fa fa-edit"></i></a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="holidayEdit"
         class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content holiday-edit">
            </div>
        </div>
    </div>

@endsection


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script>

        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        var editedRow;

        @if($currentUser->hasAccess(["module.official-holidays.edit", "module.official-holidays.update"]))
        function editHoliday(id, _this) {
            var url = '/system-settings/official-holidays/' + id + '/edit';

            editedRow = $(_this).parent().parent();

            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $(".holiday-edit").html(data);
                    $("#holidayEdit").modal('show');
                }
            });
        }

        //delete element
        $("table .delete").click(function () {
            var id = $(this).attr('id');
            var actionElement = $(this).parent();
            var cellElement = actionElement.parent();
            var rowElement = cellElement.get(0);
            swal({
                title: 'Are you sure?',
                text: "Do you want to delete this item",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: '/system-settings/official-holidays/' + id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method: "POST",
                        data: {_method: "DELETE"},
                        dataType: "json",
                        success: function (result) {
                            if (result.status === 'success') {
                                rowElement.remove();
                                swal(
                                    'Deleted!',
                                    result.message,
                                    'success'
                                )
                            } else if (result.status === 'error') {
                                swal(
                                    'Error',
                                    result.message,
                                    'warning'
                                )
                            }

                        }
                    });
                }
            })
        });

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

        function saveEditBtn(id) {
            var holiday_title = $('#edit_holiday_title').val();

            var day = $('#edit_day').val();
            $.ajax({
                url: "/system-settings/official-holidays/" + id,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "POST",
                dataType: 'json',
                data: {
                    title: holiday_title,
                    // month: month,
                    day: day,
                    month_day: day,
                    _method: "PUT"
                },
                success: function (response) {
                    if (response.status) {

                        var table_holiday_title = $(editedRow).find('.table-holiday-title')[0];
                        $(table_holiday_title).text(holiday_title);

                        var table_holiday_date = $(editedRow).find('.table-holiday-date')[0];
                        $(table_holiday_date).text(day);

                        $('#holidayEdit').modal('toggle');
                    }
                    swal({
                        type: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            });
        }
        @endif

    </script>
@endsection
@endif
