<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal-header">
    <h5 class="modal-title"> Edit Applicant</h5>
</div>
<div class="modal-body">
    <form class="mt-5" role="form" id="updateApplicant" enctype="multipart/form-data" data-parsley-validate="">
        {{ csrf_field() }}
        <input type="hidden" id="fid" value="{{$applicant->id}}">
        <div class="row">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="first_name_edit" class="label-sm hr-default-text"> First Name *</label>
                <input type="text" class="form-control required info-required" name="user[first_name]"
                       id="first_name_edit"
                       value="{{old('user.first_name')? old('user.first_name') : $applicant->first_name}}" autofocus
                       required="">
                @if ($errors->has('user.first_name'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="last_name_edit" class="label-sm hr-default-text"> Last Name *</label>
                <input type="text" class="form-control required info-required" name="user[last_name]"
                       id="last_name_edit"
                       value="{{old('user.last_name')? old('user.last_name') : $applicant->last_name}}"
                       autofocus required="">
                @if ($errors->has('user.last_name'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="gender_edit" class="label-sm hr-default-text"> Gender *</label>
                <select class="form-control required selectpicker" name="user[gender]" id="gender_edit" required>
                    <option value="">Please select gender</option>
                    @foreach ($gender_enum as $gender)
                        <option {{old('user.gender') ? (old('user.gender') == $gender ? 'selected' : '') : ($applicant->gender == $gender ? 'selected' : '')}}
                                value="{{old('user.gender')? old('user.gender') : $gender}}">{{$gender}}</option>
                    @endforeach
                </select>
                @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="email_edit" class="label-sm hr-default-text"> Email *</label>
                <input type="text" class="form-control required info-required" name="user[email]"
                       id="email_edit"
                       value="{{old('user.email')? old('user.email') : $applicant->email}}"
                       autofocus required="">
                @if ($errors->has('user.email'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="contact_edit" class="label-sm hr-default-text"> Phone Number *</label>
                <input type="text" class="form-control required info-required" name="user[contact]"
                       id="contact_edit"
                       value="{{old('user.contact')? old('user.contact') : $applicant->contact}}"
                       autofocus required="">
                @if ($errors->has('user.contact'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="job_position_edit" class="label-sm hr-default-text">Job position</label>
                <select id="job_position_edit" name="user[job_vacancy_id]" class="selectpicker" data-live-search="true">
                    <option value="">Select position</option>
                    @foreach ($job_vacancies_all as $position_dropdown)
                        <option value="{{$position_dropdown->id}}" {{ $position_dropdown->id === $applicant->job_vacancy_id ? 'selected' : '' }}>{{$position_dropdown->position}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">

                <label for="Curiculum" class="hr-default-text mb-0">Curriculum</label>
                <div class="upload-file">
                    <input name="user[cv_path]" id="curiculum_edit" type="file"
                           class="input-file"
                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                    <label for="curiculum_edit" class="light-hr-input">
                        <span>Choose a file</span>
                        <strong> <i class="fa fa-upload"></i>

                        </strong>
                    </label>
                </div>
                @if(isset($applicant->cv_path))
                    <div class="row">
                        <div class="col align-self-center">
                            <a href="{{ asset('/').$applicant->cv_path }}" target="_blank"><i class="fa fa-download"></i> Download CV</a>
                        </div>
                    </div>
                @endif
                <input type="hidden" name="docs[category_name]" value="CV">
                <ul class="parsley-errors-list cv_error">
                    <li class="parsley-required">This value is required.</li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="status_edit" class="label-sm hr-default-text"> Status</label>
                <select class="form-control required selectpicker" name="user[status]" id="status_edit" required>
                    @foreach ($statuses as $status)
                        <option {{old('user.status') ? (old('user.status') == $status ? 'selected' : '') : ($applicant->status == $status ? 'selected' : '')}}
                                value="{{old('user.status')? old('user.status') : $status}}">{{$status}}</option>
                    @endforeach
                </select>
                @if ($errors->has('status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-lg-4 col-md-12 align-self-center  {{ $errors->has('user.application_date') ? ' has-error' : '' }}">
                <label for="application_date" class="label-sm hr-default-text"> Application Date</label>
                <div class="input-group date" data-provide="datepicker"
                     data-date-format="dd-mm-yyyy">
                    <input type="text" class="form-control"
                           name="user[application_date]" id="user[application_date]"
                           value="{{old('application_date')? old('application_date') : $applicant->application_date}}">
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
                @if ($errors->has('user.application_date.0'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="skills_edit" class="label-sm hr-default-text"> Skills</label>
                <select class="selectpicker" id="skills_edit" name="skills_edit[]" multiple title="Choose one of the following..." data-live-search="true" data-parsley-multiple="skills[]">

                    @foreach ($skills as $skill)
                        <option {{old('skills_edit') ? (in_array(old('skills_edit'), array_column($applicant->skills->toArray(), 'id')) ? 'selected' : '') : (in_array($skill->id, array_column($applicant->skills->toArray(), 'id')) ? 'selected' : '')}}
                                value="{{$skill->id}}">{{$skill->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-sm-12 align-self-center {{ $errors->has('comment') ? ' has-error' : '' }}">
                <label for="comment" class="label-sm hr-default-text">Comment*</label>
                <textarea type="text" name="comment" class="form-control" value="{{ old('comment') }}"
                          id="comment" placeholder="Write your comment.." autofocus></textarea>
                @if ($errors->has('comment'))
                    <span class="help-block">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
            <button type="button" class="btn btn-small btn-success saveUpdates"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
        </div>
    </form>
</div>

<script>

    $(window).bind("load", function () {
        $('.spinnerBackground').fadeOut(500);
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

    //file upload input
    $('.input-file').click(function () {
        setFileNameOnUpload($(this));
    });

    function saveData() {
        var data = $("#updateApplicant").serializeArray();

        var formData = new FormData();

        var cvFile = document.querySelector('#curiculum_edit');

        if (typeof cvFile.files[0] !== "undefined" && cvFile.files[0] !== null) {
            formData.append("user[cv_path]", cvFile.files[0]);
        }

        $.each(data, function (key, input) {
            formData.append(input.name, input.value);
        });
        var url = '{{ route("module.applicants.update", ["id" => $applicant->id]) }}';

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status) {
                    $('#editApplicantModal').modal('hide');
                    swal({
                        type: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1000,
                        onOpen: () => {
                            swal.showLoading()
                        }
                    }).then(function (result) {
                        $.ajax({
                            method: "GET",
                            url : '{{route("module.applicants.load-table")}}',
                            success : function (response) {
                                $("#loadTable").html(response)
                                $('#editRequest').modal('hide');

                            }
                        });
                    });
                } else {
                    $(".editApplicantModal").html(response);
                }
            },
            error: function (error) {
                console.log(error);
            }

        });
    }

    $(document).ready(function () {

        $('.selectpicker').selectpicker();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".saveUpdates").on('click', function(){
            // saveData();
             $(this).parsley().validate();
             if($('#updateApplicant').parsley().isValid()) {
                 saveData();
             } else {
                 setTimeout(function () {
                     $('#updateApplicant').parsley().validate();
                 }, 50);
             }
        });

    });

    $('#updateForm').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

</script>
