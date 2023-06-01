@if($currentUser->hasAccess(['module.employee.update', 'module.employee.edit']))

    <script type="text/javascript">
        $('.selectpicker').selectpicker({});
    </script>
    <script src="{{asset("js/circleDonutChart.js")}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="header">
        @if(isset($modalCtrl))
            @if($modalCtrl == 1)
                {{--mbylljen e modalit me js--}}
            @endif
        @endif
        <button type="button" class="btn btn-sm hr-button pull-right closeProject" data-dismiss="modal"> Close</button>
    </div>
    <div class="container">
        <form role="form" id="updateProjectForm" enctype="multipart/form-data" data-parsley-validate="">
            {{ csrf_field() }}
            <div class="row mx-4">
                <div class="col-12">
                    <div class="row mt-5">
                        <b class="hr-default-text">Edit training/project details</b>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-6 col-xl-6 col-md-12">
                            <label class="hr-default-text">Company</label>
                            <select class="selectpicker required" name="project[project_company]" required=""
                                    id="job_status_edit">
                                <option value="">Please select a company</option>
                                @foreach ($company_project as $comp)
                                    <option {{old('project.project_company') ? (old('project.project_company') == $comp ? 'selected' : '') : ($editedProject->project_company == $comp ? 'selected' : '')}}
                                            value="{{old('project.project_company') ? old('project.project_company') : $comp}}">{{$comp}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-12">
                            <label for="Position" class="hr-default-text">Working status</label>
                            <select class="selectpicker required" name="project[project_type]"
                                    id="job_status_edit" required="">
                                <option value="">Please select current status</option>
                                @foreach ($project_type as $type)
                                    <option {{old('project.project_type') ? (old('project.project_type') == $type ? 'selected' : '') : ($editedProject->project_type == $type ? 'selected' : '')}}
                                            value="{{old('project.project_type') ? old('project.project_type') : $type}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-6 col-xl-6 col-md-12">
                            <label class="hr-default-text">Name</label>
                            <input type="text" class="form-control required info-required" name="project[project_name]"
                                   value="{{old('project.project_name')? old('project.project_name') : $editedProject->project_name}}"
                                   autofocus placeholder="Please add a name" required="">
                        </div>
                        <div class="col-lg-4 col-xl-3 col-md-12">
                            <label class="hr-default-text">Starting Date</label>
                            <div class="input-group date" data-provide="datepicker"
                                 data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" required=""
                                       name="project[start_training]" id="edit-start_date"
                                       placeholder="Choose date" value="{{old('project.start_training')? old('project.start_training') : $editedProject->start_training}}">
                                <div class="input-group-addon calendar-icon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3 col-md-12">
                            <label class="hr-default-text">Ending Date</label>
                            <div class="input-group date" data-provide="datepicker"
                                 data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control"
                                       name="project[end_training]" id="edit-end_date" placeholder="Choose date"
                                       value="{{old('project.end_training')? old('project.end_training') : $editedProject->end_training}}">
                                <div class="input-group-addon calendar-icon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                            <input type="checkbox" name="project[unlimited_project]" value="{{ $editedProject->unlimited_project == "0" ? 1 : 0 }}" {{ $editedProject->unlimited_project == "1" ? "checked" : '' }}> Current
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-6 col-xl-4 col-md-12">
                            <label for="evaluation" class="hr-default-text">Evaluation</label>
                            <input type="text" class="form-control" name="project[project_estimation]"
                                   value="{{old('project.project_estimation')? old('project.project_estimation') : $editedProject->project_estimation}}"
                                   autofocus placeholder="Please complete your evaluation" required="">
                        </div>
                        <div class="col-lg-6 col-xl-4 col-md-12">
                            <label for="evaluation" class="hr-default-text">Performance level</label>
                            <input type="number" min="1" max="5" class="form-control" name="project[performance_level]"
                                   value="{{old('project.performance_level')? old('project.performance_level') : $editedProject->performance_level}}"
                                   autofocus placeholder="Please complete your evaluation" required="">
                            <small style="color: #ffbf49;">Please fill in numbers from 1 to 5.</small>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-12">
                            <label class="hr-default-text">Evaluation date</label>
                            <div class="input-group date" data-provide="datepicker"
                                 data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" required=""
                                       name="project[evaluation_date]" placeholder="Choose date"
                                       value="{{old('project.evaluation_date')? old('project.evaluation_date') : $editedProject->evaluation_date}}">
                                <div class="input-group-addon calendar-icon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-6 col-xl-6 col-md-12">
                            <label for="skills_edit" class="hr-default-text">Skills</label>
                            <select class="selectpicker" id="skills_edit" required="" name="project_skills[]" multiple title="Choose one of the following..." data-live-search="true" data-parsley-multiple="projects[]">
                                @foreach ($skills as $skill)
                                    <option {{old('project_skills') ? (in_array(old('project_skills'), array_column($editedProject->projectSkills->toArray(), 'id')) ? 'selected' : '') : (in_array($skill->id, array_column($editedProject->projectSkills->toArray(), 'id')) ? 'selected' : '')}}
                                            value="{{$skill->id}}">{{$skill->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row action-btn mt-5 mb-4">
                        <div class="col">
                            <button type="button" class="btn btn-sm btn-success saveUpdates"> Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <script>

        //required fields
        var infoRequiredFields = $('.info-required');

        $('#updateProjectForm').parsley();

        $('.datepicker').datepicker();

        //Remove skill tag
        function removeTag(value) {
            $(value).remove();
        }

        $('#updateProjectForm').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        @if($currentUser->hasAccess(['module.employee.update', 'module.employee.edit','module.employee.editProject','module.employee.updateProject']))

        function saveData() {

            var sweet = swal({
                text: 'Please wait',
                allowOutsideClick: false,
                onOpen: function () {
                    swal.showLoading()
                }
            });
            var data = $("#updateProjectForm").serializeArray();
            var formData = new FormData();

            $.each(data, function (key, input) {
                formData.append(input.name, input.value);
            });

            $.ajax({
                type: "POST",
                url: "{{ route("module.employee.updateProject", ["id" => $editedProject->id]) }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "Ok") {
                        $('#editUserModal').modal('hide');
                        $('.editUserModal').empty();
                        $('.modal-backdrop').remove();
                        swal({
                            type: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        updateEmpList();
                        sweet.then(function (result) {
                            result.dismiss === swal.DismissReason.timer;
                        });
                    } else {
                        $('.editUserModal').empty();
                        $(".editUserModal").html(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }

            })
        }

        @endif

        function validateInfoTab() {
            if (isValidInfoTab()) {
                $.each($('.req-tab-info'), function () {
                    $(this).addClass('d-none');
                    $(this).removeClass('req-tab');
                })
            }
        }

        $.each(infoRequiredFields, function () {
            $(this).on('keypress change', validateInfoTab);
        });

        $.each(infoRequiredFields, validateInfoTab);

        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".saveUpdates").on('click', function () {
                $(this).parsley().validate();
                if ($('#updateProjectForm').parsley().isValid()) {
                    $(this).attr('disabled', true);
                    saveData();
                } else {
                    setTimeout(function () {
                        $('#updateProjectForm').parsley().validate();
                    }, 50);
                }
            });
        });

    </script>

@endif