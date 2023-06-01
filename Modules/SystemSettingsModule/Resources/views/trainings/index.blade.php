@if($currentUser->hasAccess('module.trainings.index'))

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

                    <div class="row mb-4 pl-4">
                        <div class="col">
                            <h5 class="hr-default-text mb-4">Trainings</h5>
                        </div>
                    </div>

                    <div class="row">
                        @if($currentUser->hasAccess('module.trainings.store'))
                            <div class="col-4">
                                {{ Form::open([ 'route' => ['module.trainings.store'], 'files' => true ]) }}
                                <div class="row">
                                    <div class="col align-self-end">
                                        <label for="training_title" class="label-sm hr-default-text">Title</label>
                                        {{ Form::text('title', '', array('class' => 'form-control', 'required' => 'required')) }}
                                    </div>
                                    <div class="col">
                                        <label for="training_title" class="label-sm hr-default-text">Department</label>
                                        {{ Form::select('department_id', $departments->pluck('name', 'id'), '', ['class' => 'form-control selectpicker', 'required' => 'required', 'data-live-search' => 'true']) }}
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col">
                                        <label for="start_date" class="label-sm hr-default-text">Start Date</label>
                                        {{--{{Form::date('start_date', null, array('class' => 'form-control'))}}--}}
                                        <div class="input-group date date_start_date" data-provide="datepicker"
                                             data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control" id="create_start_date" name="start_date"
                                                   onchange="setMinDateCreate();" required>
                                            <div class="input-group-addon calendar-icon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label for="end_date" class="label-sm hr-default-text">End Date</label>
                                        {{--{{Form::date('end_date', null, array('class' => 'form-control'))}}--}}
                                        <div class="input-group date training_end_date" data-provide="datepicker"
                                             data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control training_end_date" id="create_end_date"
                                                   name="end_date" required>
                                            <div class="input-group-addon calendar-icon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-6">
                                        <label for="" class="label-sm hr-default-text">Upload file</label>
                                        <div class="upload-file">
                                            <input id="uploadFile" type="file" class="input-file" name="training_file"
                                                   accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
                                            <label for="uploadFile" class="light-hr-input">
                                                <span></span>
                                                <strong class="pull-right">
                                                    <i class="fa fa-upload"></i>
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col">
                                        <label for="training_description" class="label-sm hr-default-text">Description</label>
                                        <textarea name="training_description" id="training_description"
                                                  class="form-control requestDesc" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-2 align-self-end">
                                        {{ Form::submit('Create', array('class' => 'btn btn-small btn-primary')) }}
                                    </div>
                                </div>

                                {{ Form::close() }}
                            </div>
                        @endif
                        <div class="@if($currentUser->hasAccess('module.trainings.store')) col-8 @else col @endif">
                            <div class="row mb-5 pl-4">
                                <div class="col">
                                    <table class="table" id="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Training</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">File</th>

                                            @if($currentUser->hasAnyAccess(['module.trainings.edit', 'module.trainings.update', 'module.trainings.destroy']))
                                                <th>Operations</th>
                                            @endif

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($trainings as $training)
                                            <tr>
                                                <td class="training-title-data table-ellipse-text">{{$training->title}}</td>
                                                <td class="training-desc-data table-ellipse-text">{{$training->training_description}}</td>
                                                <td class="training-dept-data">{{ ($training->departments !== null)? $training->departments->name : '' }}</td>
                                                <td class="training-startDate-data">{{ \Carbon\Carbon::parse($training->start_date)->format('d-m-Y') }}</td>
                                                <td class="training-endDate-data">{{ \Carbon\Carbon::parse($training->end_date)->format('d-m-Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ Storage::url($training->training_file) }}" target="_blank">

                                                        <i class="fa fa-download default-color"></i>
                                                    </a>
                                                </td>
                                                @if($currentUser->hasAnyAccess(['module.trainings.edit', 'module.trainings.update', 'module.trainings.destroy']))

                                                    <td>
                                                        @if($currentUser->hasAccess(['module.trainings.destroy']))
                                                            {!! Form::button('<i class="fa fa-trash-o"  data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['class' => 'btn btn-sm hr-outline pull-right delete', 'type' => 'button', 'id' => $training->id]) !!}
                                                        @endif

                                                        @if($currentUser->hasAccess(['module.trainings.edit', 'module.trainings.update']))
                                                            <button class="btn btn-sm hr-outline pull-right"
                                                                    style="margin-right: 3px;"
                                                                    data-toggle="modal" data-target="#positionEdit"
                                                                    onclick="editTrainings('{{ $training->id }}', this)"><i
                                                                        class="fa fa-edit" data-toggle="tooltip"
                                                                        data-placement="top" title="Edit"></i></button>
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


    <div id="trainingEdit"
         class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content training-edit">
            </div>
        </div>
    </div>

@endsection


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script>

        var editedRow;
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

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

        function editTrainings(id, _this) {
            var url = '/system-settings/trainings/' + id + '/edit';
            editedRow = $(_this).parent().parent();

            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $(".training-edit").html(data);
                    $("#trainingEdit").modal('show');
                }
            });
        }

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
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: '/system-settings/trainings/' + id,
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
            var training_title = $('#training-title').val();
            var edit_training_description = $('#edit_training_description').val();
            var start_date = $('#training-start-date').val();
            var end_date = $('#training-end-date').val();
            var department_id = $('#training_dept').val();
            var selectedDept = $('#training_dept option:selected').text();

            var data = $("#editTraining").serializeArray();
            var formData = new FormData();

            var file = document.querySelector('.training_file');
            if (typeof file.files[0] !== "undefined" && file.files[0] !== null) {
                formData.append("training_file", file.files[0]);
                var training_file = file.files[0];
            }
            $.each(data, function (key, input) {
                formData.append(input.name, input.value);
            });
            formData.append('_method', 'PUT');

            $.ajax({
                url: "/system-settings/trainings/" + id,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "POST",
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        var training_title_data = $(editedRow).find('.training-title-data')[0];
                        $(training_title_data).text(training_title);

                        var training_desc_data = $(editedRow).find('.training-desc-data')[0];
                        $(training_desc_data).text(edit_training_description);

                        var training_dept_data = $(editedRow).find('.training-dept-data')[0];
                        $(training_dept_data).text(selectedDept);

                        var training_startDate_data = $(editedRow).find('.training-startDate-data')[0];
                        $(training_startDate_data).text(start_date);

                        var training_endDate_data = $(editedRow).find('.training-endDate-data')[0];
                        $(training_endDate_data).text(end_date);

                        $('#trainingEdit').modal('toggle');
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

        $('.date_start_date').datepicker({
            startDate: new Date()
        });

        function setMinDateCreate() {
            $("#create_end_date").val('');
            var $trainingEndDate = $('.training_end_date');

            $trainingEndDate.datepicker('destroy');
            $trainingEndDate.datepicker({
                format: 'dd-mm-yyyy',
                startDate: $("#create_start_date").val()
            });
        }

        function setFileNameOnUpload(el) {
            console.log(el);
            var $input = el,
                $label = $input.next('label'),
                labelVal = $label.html();

            $input.on('change', function (e) {
                var fileName = '';
                if (e.target.value) {
                    fileName = e.target.value.split('\\').pop();
                }
                if (fileName) {
                    $label.find('span').html(fileName);
                } else {
                    $label.html(labelVal);
                }
            });
            $input
                .on('focus', function () {
                    $input.addClass('has-focus');
                })
                .on('blur', function () {
                    $input.removeClass('has-focus');
                });
        }

        $('.input-file').click(function () {
            setFileNameOnUpload($(this));
        });

    </script>
@endsection
@endif
