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
                    <option value="*">All Vacancies</option>
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
                <select class="selectpicker hr-input" data-live-search="true" id="filters_application">
                    <option value="*">Start Date</option>
                    @foreach ($applicants as $app)
                        @if($app->quit_date)
                            <option value="{{$app->quit_date}}">
                                {{$app->quit_date}}
                            </option>
                        @endif
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
                            <b class="hr-default-text mb-4">Pre-hired Applicants</b>
                        </div>
                    </div>


                    <div class="row mt-3 mb-2 pl-1">
                        <div class="col" id="loadTable">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--Modal--}}
    <div id="approveApplicantModal"
         class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body approveApplicantModal editUserModal">
                </div>
            </div>

        </div>
    </div>
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
                url: '{{route("module.pre-hired.load-table")}}',
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

        function approveApplicant(applicant_id) {
            var url = '{{ route("module.pre-hired.approve", ":id") }}';
            url = url.replace(':id', applicant_id);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "HTML",
                success: function (data) {
                    $(".approveApplicantModal").html(data);
                    $("#approveApplicantModal").modal('show');
                }
            });

        }

        function editApplicant(applicant_id) {
            var url = '{{ route("module.pre-hired.edit", ":id") }}';
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

        $grid = $('#interviews').isotope({
            itemSelector: '.applicant',
            layoutMode: 'vertical',
            transitionDuration: 0
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
