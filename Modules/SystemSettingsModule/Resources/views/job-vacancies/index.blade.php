@if($currentUser->hasAccess('module.job-vacancies.index'))
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
                            <h5 class="hr-default-text">Job Vacancies</h5>
                        </div>
                    </div>

                    {{--<div class="row">--}}
                    {{--<div class="col">--}}
                    {{--<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#share">--}}
                    {{--Share job vacancy--}}
                    {{--</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="row">
                        @if($currentUser->hasAccess(["module.job-vacancies.store"]))
                            <div class="col-4">
                                {{ Form::open([ 'route' => ['module.job-vacancies.store'], 'class' => 'store-item' ]) }}

                                <div class="row mt-5 mb-5">
                                    <div class="col">
                                        <label for="job_position" class="label-sm hr-default-text">Job position</label>
                                        <select id="job_position" name="job_position" class="selectpicker" data-live-search="true">
                                            @foreach ($job_positions as $job_position)
                                                <option value="{{$job_position->title}}">{{$job_position->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="expiration" class="label-sm hr-default-text">Expiration date</label>
                                        {{--{{Form::date('expiration', \Carbon\Carbon::now(), array('class' => 'form-control'))}}--}}
                                        <div class="input-group date date_start_date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control" id="expiration_start_date" name="expiration">
                                            <div class="input-group-addon calendar-icon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="description" class="label-sm hr-default-text">Description</label>
                                        <textarea name="description" id="description" class="form-control requestDesc" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col align-self-end">
                                        {{ Form::submit('Create', array('class' => 'btn btn-small btn-primary')) }}
                                    </div>
                                </div>

                                {{ Form::close() }}
                            </div>
                        @endif
                        <div class="@if($currentUser->hasAccess(["module.job-vacancies.store"])) col-8 @else col @endif">
                            <div class="row">
                                <div class="col">
                                    <table class="table" id="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Position Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Expiration Date</th>
                                            @if($currentUser->hasAnyAccess(["module.job-vacancies.destroy", "module.job-vacancies.update", "module.job-vacancies.edit"]))
                                                <th scope="col">Operations</th>
                                            @endif
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($jobVacancies as $jobVacancy)
                                            <tr>
                                                <td class="position-title-data">{{$jobVacancy->position}}</td>
                                                <td class="position-desc-data table-ellipse-text">{{$jobVacancy->description}}</td>
                                                <td class="position-expiration">{{$jobVacancy->expiration}}</td>
                                                @if($currentUser->hasAnyAccess(["module.job-vacancies.edit", "module.job-vacancies.update", "module.job-vacancies.destroy"]))
                                                    <td>
                                                        @if($currentUser->hasAccess(["module.job-vacancies.destroy"]))
                                                            {!! Form::button('<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['class' => 'btn btn-sm hr-outline pull-right delete', 'type' => 'button', 'id' => $jobVacancy->id ]) !!}
                                                        @endif

                                                        @if($currentUser->hasAccess(["module.job-vacancies.edit", "module.job-vacancies.update"]))
                                                            <button class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;"
                                                                    data-toggle="modal" data-target="#jobVacancyEdit"
                                                                    onclick="editJobVacancy('{{ $jobVacancy->id }}', this)"><i  data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i>
                                                            </button>
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
        </div>
    </div>

    <div id="jobVacancyEdit"
         class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content job-vacancy-edit">
            </div>
        </div>
    </div>
    <div id="share" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share job notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt-3">
                        <div class="col">
                            <label class="hr-default-text">{{ trans("label.upload_file") }}</label>
                            <div class="upload-file">
                                <input id="uploadFile" type="file" class="input-file" name="training_file" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
                                <label for="uploadFile" class="light-hr-input">
                                    <span>{{ trans("label.upload_file") }}</span>
                                    <strong class="pull-right">
                                        <i class="fa fa-upload"></i>
                                    </strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 pl-2">
                        <div class="col">
                            <p class="social-share">Share on: &nbsp; <span class="fa fa-facebook-f"></span> &nbsp; <span class="fa fa-instagram"></span> &nbsp;  <span class="fa fa-linkedin"></span></p>
                        </div>
                    </div>
                </div>
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
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

        $(function () {
            var oDataTable = $('#table').DataTable({
                "ordering": false,
                drawCallback: function (settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            $('#myInputTextField').keyup(function () {
                oDataTable.search($(this).val()).draw();
            })
        });

        @if($currentUser->hasAccess(["module.job-vacancies.edit", "module.job-vacancies.update"]))
        function editJobVacancy(id, _this) {
            var url = '/system-settings/job-vacancies/' + id + '/edit';
            editedRow = $(_this).parent().parent();
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $(".job-vacancy-edit").html(data);
                    $("#jobVacancyEdit").modal('show');
                }
            });

        }

        function saveEditBtn(id) {
            var job_position = $('#job_position_title').val();
            var expiration = $('#job_position_expiration').val();
            var jp_description = $('#jp_description').val();
            $.ajax({
                url: "/system-settings/job-vacancies/" + id,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "POST",
                dataType: 'json',
                data: {
                    job_position: job_position,
                    expiration: expiration,
                    description: jp_description,
                    _method: "PUT"
                },
                success: function (response) {
                    if (response.status) {
                        var position_title_data = $(editedRow).find('.position-title-data')[0];
                        $(position_title_data).text(job_position);

                        var position_expiration = $(editedRow).find('.position-expiration')[0];
                        $(position_expiration).text(expiration);

                        var position_desc_data = $(editedRow).find('.position-desc-data')[0];
                        $(position_desc_data).text(jp_description);

                        $('#jobVacancyEdit').modal('toggle');
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

        @if($currentUser->hasAccess(["module.job-vacancies.destroy"]))
        //    delete element
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
            }).then(function(result) {
                if(result.value)
            {
                $.ajax({
                    url: '/system-settings/job-vacancies/' + id,
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
        @endif

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

        $('.date_start_date').datepicker({
            startDate: new Date()
        });


    </script>
@endsection
@endif
