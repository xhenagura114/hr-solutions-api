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
            <div class="col-lg-3 col-md-12">
                <input type="text" class="form-control hr-input" id="myInputTextField">
            </div>
        </div>
        <div class="hr-content pt-3 pb-3">
            @if(Session::has('flash_message'))
                <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                </div>
            @endif
            <div class="h-100 scroll">
                <div class="row pl-0 pr-5">
                    {{--<div class="col filters">--}}
                        {{--<div class="btn-group btn-group-toggle filter-buttons" id="filters" data-toggle="buttons">--}}
                            {{--<label class="btn btn-light all active">--}}
                                {{--<input type="radio" name="options" id="all" autocomplete="off" data-filter="*" checked> All--}}
                            {{--</label>--}}

                            {{--@foreach ($job_positions as $position)--}}
                                {{--<label class="btn btn-light">--}}
                                    {{--<input type="radio" name="options" id="optiondep-{{$position->id}}"--}}
                                           {{--autocomplete="off" data-filter=".optiondep-{{$position->id}}"--}}
                                           {{--checked> {{$position->title}}--}}
                                {{--</label>--}}
                            {{--@endforeach--}}

                        {{--</div>--}}
                    {{--</div>--}}
                </div>

                <div class="container-fluid">
                    <div class="row mb-4 pl-4 mt-4">
                        <div class="col">
                            <b class="hr-default-text mb-4">Internship</b>
                        </div>
                    </div>

                    <form class="mt-5 mb-5 pl-4" role="form" id="form" method="POST"
                          action="{{ route('module.internship.store') }}" enctype="multipart/form-data"
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
                                <label for="email_create" class="label-sm hr-default-text"> {{ trans("label.email") }}</label>
                                <input type="text" name="email_create" class="form-control" value="{{ old('email_create') }}"
                                       id="email_create" autofocus>
                                @if ($errors->has('email_create'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('email_create') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('contact_create') ? ' has-error' : '' }}">
                                <label for="contact_create" class="label-sm hr-default-text"> Phone Number</label>
                                <input type="text" name="contact_create" class="form-control"
                                       value="{{ old('contact_create') }}" id="contact_create" autofocus>
                                @if ($errors->has('contact_create'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('contact_create') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('gender_create') ? ' has-error' : '' }}">
                                <label class="label-sm hr-default-text"> Gender</label>
                                {{ Form::select("gender_create",  array('' => 'Please select gender') + $gender_enum , 'default', ['class' => 'selectpicker']) }}
                                @if ($errors->has('gender_create'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top">
                                <label for="interests_create" class="label-sm hr-default-text">Interests</label>
                                <select id="interests_create" name="interests_create[]" class="selectpicker" multiple
                                        title="Choose one of the following..." data-live-search="true" data-parsley-multiple="interests[]">
                                    @foreach ($job_positions as $position_dropdown)
                                        <option value="{{$position_dropdown->title}}">{{$position_dropdown->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('institution_create') ? ' has-error' : '' }}">
                                <label for="institution_create" class="label-sm hr-default-text"> Educational Institution</label>
                                <input type="text" name="institution_create" class="form-control"
                                       value="{{ old('institution_create') }}" id="institution_create" autofocus>
                                @if ($errors->has('institution_create'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('institution_create') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('education_create') ? ' has-error' : '' }}">
                                <label class="label-sm hr-default-text">Level of Education</label>
                                {{ Form::select("education_create",  array('' => 'Select education') + $enumoption, 'default', ['class' => 'selectpicker']) }}
                                @if ($errors->has('education_create'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('education_create') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('studying_for_create') ? ' has-error' : '' }}">
                                <label class="label-sm hr-default-text">Studying For</label>
                                <input type="text" name="studying_for_create" class="form-control"
                                       value="{{ old('studying_for_create') }}" id="studying_for_create" autofocus>
                                @if ($errors->has('studying_for_create'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('studying_for_create') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-12 align-self-top  {{ $errors->has('comments_create') ? ' has-error' : '' }}">
                                <label for="comments_create" class="label-sm hr-default-text"> Comments</label>
                                <input type="text" name="comments_create" class="form-control"
                                       value="{{ old('comments_create') }}" id="comments_create" autofocus>
                                @if ($errors->has('comments_create'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('comments_create') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-2 col-md-3 align-self-top">
                                <div class="col">
                                    <button type="submit" class="btn btn-small btn-success pull-right" id="save-btn"> Create
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="row mt-3 mb-2 pl-1">
                        <div class="col" id="loadTable">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Modal--}}
    <div id="approveInternshipModal"
         class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body approveInternshipModal editUserModal">
                </div>
            </div>

        </div>
    </div>
    <div id="editInternshipModal"
         class="modal fade" role="dialog">
        <div class="modal-dialog" style="max-width: 800px">
            <div class="modal-content">
                <div class="modal-body editInternshipModal editUserModal">
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

        $('#form').parsley();

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

        $(window).bind("load", function () {

            $.ajax({
                method: "GET",
                url: '{{route("module.internship.load-table")}}',
                success: function (response) {
                    $('.spinnerBackground').fadeOut(500);

                    $("#loadTable").html(response)
                }
            });

        });

        function approveInternship(internship_id) {
            var url = '{{ route("module.internship.approve", ":id") }}';
            url = url.replace(':id', internship_id);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "HTML",
                success: function (data) {
                    $(".approveInternshipModal").html(data);
                    $("#approveInternshipModal").modal('show');
                }
            });

        }

        function editInternship(internship_id) {
            var url = '{{ route("module.internship.edit", ":id") }}';
            url = url.replace(':id', internship_id);

            $.ajax({
                type: "GET",
                url: url,
                dataType: "HTML",
                success: function (data) {
                    $(".editInternshipModal").html(data);
                    $("#editInternshipModal").modal('show');
                }
            });

        }

        $(function () {
            var oDataTable = $('#table').DataTable({
                "ordering": false
            });
            $('#myInputTextField').keyup(function () {
                oDataTable.column(0).search($(this).val()).draw();
            })

        });

        $grid = $('#internship').isotope({
            itemSelector: '.applicant',
            layoutMode: 'vertical',
            transitionDuration: 0
        });

        $('#filters').on('click', '.btn', function () {
            var child = $(this).find('input');
            var filterValue = child.attr('data-filter');
            $grid.isotope({filter: filterValue});
        });

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
