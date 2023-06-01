@extends('employeemanagementmodule::layouts.employees-management-extendable',['pageTitle' => 'Employee Management'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{asset('js/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <script src="{{ asset("js/parsley.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="searchBar">
            <p class="mb-0">Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-lg-3 col-md-6">
                <input type="text" class="form-control hr-input" id="myInputTextField">
            </div>
            <div class="col-lg-3 col-md-6">
                <select class="selectpicker hr-input" data-live-search="true" id="filters">
                    <option value="">All Vacancies</option>
                    @foreach ($job_vacancies as $position)
                        @if($position->job_vacancy_id)
                            <option value="{{$position->jobVacancies->position}}">
                                {{$position->jobVacancies->position}}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <select class="selectpicker hr-input" data-live-search="true" id="filter_status">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{$status}}">
                            {{$status}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="hr-content pt-3 pb-3">
            <div class="h-100 scroll">
                @if(Session::has('flash_message'))
                    <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                    </div>
                @endif

                <div class="container-fluid">
                    <div class="row mb-4 pl-4 mt-4">
                        <div class="col">
                            <b class="hr-default-text mb-4">Applicants</b>
                        </div>
                    </div>

                    <form class="mt-5 mb-5 pl-4" role="form" id="form" method="POST"
                          action="{{ route('module.applicants.store') }}" enctype="multipart/form-data"
                          data-parsley-validate="">
                        {{ csrf_field() }}

                        <div class="row mb-5">
                            <div class="col-lg-3 col-md-12 align-self-top {{ $errors->has('first_name_create') ? ' has-error' : '' }}">
                                <label for="first_name" class="label-sm hr-default-text"> {{ trans("label.firstname") }}
                                    *</label>
                                <input type="text" name="first_name_create" class="form-control"
                                       value="{{ old('first_name_create') }}" id="first_name_create" required="" autofocus>
                                @if ($errors->has('first_name_create'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name_create') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('last_name_create') ? ' has-error' : '' }}">
                                <label for="last_name_create" class="label-sm hr-default-text"> {{ trans("label.lastname") }}
                                    *</label>
                                <input type="text" name="last_name_create" class="form-control"
                                       value="{{ old('last_name_create') }}" id="last_name_create" required="" autofocus>
                                @if ($errors->has('last_name_create'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('last_name_create') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('email_create') ? ' has-error' : '' }}">
                                <label for="email_create" class="label-sm hr-default-text"> {{ trans("label.email") }} *</label>
                                <input type="text" name="email_create" class="form-control" value="{{ old('email_create') }}"
                                       id="email_create" required="" autofocus>
                                @if ($errors->has('email_create'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('email_create') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('contact_create') ? ' has-error' : '' }}">
                                <label for="contact_create" class="label-sm hr-default-text"> Phone Number *</label>
                                <input type="text" name="contact_create" class="form-control"
                                       value="{{ old('contact_create') }}" id="contact_create" required="" autofocus>
                                @if ($errors->has('contact_create'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('contact_create') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="label-sm hr-default-text">Gender *</label>
                                {{ Form::select("gender",  array('' => 'Please select gender') + $gender_enum , 'default', ['class' => 'selectpicker']) }}
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top">
                                <label for="job_position" class="label-sm hr-default-text">Job Vacancy*</label>
                                <select id="job_position" name="job_position" class="selectpicker" data-live-search="true">
                                    <option value="">Please select a job</option>
                                    @foreach ($job_vacancies_all as $position_dropdown)
                                        <option value="{{$position_dropdown->id}}">{{$position_dropdown->position}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-center {{ $errors->has('docs.cv_path') ? ' has-error' : '' }}">
                                <label for="docs[cv_path]"
                                       class="label-sm hr-default-text"> {{ trans("label.curriculum") }}</label>
                                <div class="upload-file">
                                    <input name="docs[cv_path]" id="cv_path1" type="file" class="input-file"
                                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf"
                                           data-parsley-group="first">
                                    <label for="cv_path1" class="light-hr-input cv_label">
                                        <span>Upload a file</span>
                                        <strong class="pull-right"> <i class="fa fa-upload"></i></strong>
                                    </label>
                                </div>
                                <input type="hidden" name="docs[category_name]" value="CV">
                                <ul class="parsley-errors-list cv_error">
                                    <li class="parsley-required">{{ trans("message.required") }}.</li>
                                </ul>

                                @if ($errors->has('docs.cv_path'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('docs.cv_path') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top">
                                <label for="status" class="label-sm hr-default-text">Status </label>
                                <select id="status" name="status" class="selectpicker" data-live-search="true">
                                    @foreach ($statuses as $status)
                                        <option value="{{$status}}">{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('application_date') ? ' has-error' : '' }}">
                                <label for="application_date" class="label-sm hr-default-text"> Application Date*</label>
                                <div class="input-group date" data-provide="datepicker"
                                     data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control"
                                           name="application_date" id="application_date" required>
                                    <div class="input-group-addon calendar-icon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                </div>
                                @if ($errors->has('application_date.0'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top">
                                <label for="skills" class="label-sm hr-default-text">Skills</label>
                                <select id="skills" name="skills[]" class="selectpicker" multiple
                                        title="Choose one of the following..." data-live-search="true" data-parsley-multiple="skills[]">
                                    @foreach ($skills as $skill)
                                        <option value="{{$skill->id}}">{{$skill->title}}</option>
                                    @endforeach
                                </select>
                            </div>

{{--                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('work_email_create') ? ' has-error' : '' }}">--}}
{{--                                <label for="work_email_create" class="label-sm hr-default-text">Work {{ trans("label.email") }}*</label>--}}
{{--                                <input type="text" name="work_email_create" class="form-control" value="{{ old('work_email_create') }}"--}}
{{--                                       id="work_email_create" required="" autofocus>--}}
{{--                                @if ($errors->has('work_email_create'))--}}
{{--                                    <span class="help-block">--}}
{{--                                         <strong>{{ $errors->first('work_email_create') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('comment') ? ' has-error' : '' }}">
                                <label for="comment" class="label-sm hr-default-text">Comment</label>
                                <textarea type="text" name="comment" class="form-control" value="{{ old('comment') }}"
                                          id="comment" placeholder="Write your comment.." autofocus></textarea>
                                        @if ($errors->has('comment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                                        @endif
                            </div>

                            <div class="col-lg-2 col-md-3 align-self-center">
                                <div class="col">
                                    <button type="submit" class="btn btn-small btn-success pull-right" id="save-btn"> Create
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                        <div class="col" style="margin-left: 1300px;">
                            <form class="mt-2" action="{{ route("module.applicants.transferSkills") }}" method="GET" enctype="multipart/form-data" data-parsley-validate="">

                            <input type="submit" class="btn btn-xs btn-light" style="width: 150px;background-color: #9E9E9E; " value="Transfer skills">
                            </form>
                        </div>
                    <div class="row mt-3 mb-2 pl-1">
                    <div class="col" id="loadTable">
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
{{--    --}}{{--Modal--}}
{{--    <div id="approveApplicantModal"--}}
{{--         class="modal fade" role="dialog">--}}
{{--        <div class="modal-dialog modal-lg">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-body approveApplicantModal editUserModal">--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
    <div id="editApplicantModal"
         class="modal fade" role="dialog">
        <div class="modal-dialog" style="max-width: 800px">
            <div class="modal-content">
                <div class="modal-body editApplicantModal editUserModal">
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
            $.ajax({
                method: "GET",
                url: '{{route("module.applicants.load-table")}}',
                success: function (response) {
                    $('.spinnerBackground').fadeOut(500);

                    $("#loadTable").html(response)
                }
            });
        });

        $('#form').parsley();

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

        {{--function approveApplicant(applicant_id) {--}}
        {{--    var url = '{{ route("module.applicants.approve", ":id") }}';--}}
        {{--    url = url.replace(':id', applicant_id);--}}
        {{--    $.ajax({--}}
        {{--        type: "GET",--}}
        {{--        url: url,--}}
        {{--        dataType: "HTML",--}}
        {{--        success: function (data) {--}}
        {{--            $(".approveApplicantModal").html(data);--}}
        {{--            $("#approveApplicantModal").modal('show');--}}
        {{--        }--}}
        {{--    });--}}

        {{--}--}}

        function editApplicant(applicant_id) {
            var url = '{{ route("module.applicants.edit", ":id") }}';
            url = url.replace(':id', applicant_id);

            $.ajax({
                type: "GET",
                url: url,
                dataType: "HTML",
                success: function (data) {
                    $(".editApplicantModal").html(data);
                    $("#editApplicantModal").modal('show');
                }
            });

        }

        $('.input-file').click(function () {
            setFileNameOnUpload($(this));
        });

        function setFileNameOnUpload(el) {
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
                    if ($('#cv_path1').hasClass('parsley-error')) {
                        $('.cv_error').removeClass('filled');
                    }
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

        $grid = $('#applicants').isotope({
            itemSelector: '.applicant',
            layoutMode: 'vertical',
            transitionDuration: 0
        });

        // $('#filters').on('click', '.btn', function () {
        //     var child = $(this).find('input');
        //     var filterValue = child.attr('data-filter');
        //     $grid.isotope({filter: filterValue});
        // });

        /*Remove modal*/
        $('#editUserModal').on('hidden.bs.modal', function () {
            $(this).find('.editUserModal').empty();
        })

        $('#save-btn').click(function () {
            $(this).parsley().validate();
            if (!($('#cv_path1').parsley().isValid())) {
                setTimeout(function () {
                    $('#cv_path1').next('.parsley-errors-list.filled').remove();
                    $('.cv_error').addClass("filled");
                }, 50);
            }
        })
    </script>
@endsection
