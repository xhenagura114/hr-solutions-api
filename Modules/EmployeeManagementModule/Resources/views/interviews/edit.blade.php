<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
//$experience = $applicant->interviewExperiences->first();
?>

<div class="modal-header">
    <h5 class="modal-title"> Edit <b>{{$applicant->first_name}} {{$applicant->last_name}}</b></h5>
</div>
<div class="modal-body">
    <form class="mt-5" role="form" id="updateApplicant" enctype="multipart/form-data" data-parsley-validate="">
        {{ csrf_field() }}
        <input type="hidden" id="fid" value="{{$applicant->id}}">
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="email_edit" class="label-sm hr-default-text"> Email *</label>
                <input type="text" class="form-control required info-required" name="user[email]"
                       id="email_edit"
                       value="{{old('user.email')? old('user.email') : $applicant->email}}"
                       autofocus required="">
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="job_position_edit" class="label-sm hr-default-text">Job position</label>
                <select id="job_position_edit" name="user[job_vacancy_id]" class="selectpicker" data-live-search="true">
                    <option value="">Select position</option>
                    @foreach ($job_vacancies_all as $position_dropdown)
                        <option {{ $position_dropdown->id === $applicant->job_vacancy_id ? 'selected' : '' }} value="{{$position_dropdown->id}}" >{{$position_dropdown->position}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-12 align-self-center mt-1-edit">
                <label for="Curiculum" class="label-sm hr-default-text">Curriculum</label>
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
                <ul class="parsley-errors-list cv_error">
                    <li class="parsley-required">This value is required.</li>
                </ul>
                @if(isset($applicant->cv_path) and $applicant->cv_path != '')
                    <div class="row cv_download_btn">
                        <div class="col align-self-center">
                            <a href="{{ asset('/').$applicant->cv_path }}"
                               target="_blank"><i class="fa fa-download"></i> Download CV</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-10 mb-4">
            <div class="col-lg-4 col-md-12 align-self-center">
                <label class="label-sm hr-default-text"> Interview Date</label>
                <div class="input-group date" data-provide="datepicker"
                     data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control"
                           name="user[interview_date]" id="user[interview_date]"  placeholder="dd-mm-yyyy"
                           value="{{old('interview_date')? old('interview_date') : $applicant->interview_date}}">
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text">Italian Language</label>
                <select class="form-control required selectpicker" name="user[italian_language]" id="italian_language" required>
                    @foreach ($italian as $lang)
                        <option {{old('user.italian_language') ? (old('user.italian_language') == $lang ? 'selected' : '') : ($applicant->italian_language == $lang ? 'selected' : '')}}
                                value="{{old('user.italian_language')? old('user.italian_language') : $lang}}">{{$lang}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-12 align-self-center mt-1-edit">
                <label for="Curiculum" class="label-sm hr-default-text">Scan doc</label>
                <div class="upload-file">
                    <input name="user[form_path]" id="scan_edit" type="file"
                           class="input-file"
                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                    <label for="scan_edit" class="light-hr-input">
                        <span>Choose a file</span>
                        <strong> <i class="fa fa-upload"></i>
                        </strong>
                    </label>
                </div>
                @if(isset($applicant->cv_path) and $applicant->form_path != '')
                    <div class="row cv_download_btn">
                        <div class="col align-self-center">
                            <a href="{{ asset('/').$applicant->form_path }}"
                               target="_blank"><i class="fa fa-download"></i> Download scan</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-10 mb-4">
            <div class="col-lg-4 col-md-12 align-self-center}}">
                <label class="label-sm hr-default-text">Work start Date</label>
                <div class="input-group date" data-provide="datepicker"
                     data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control"
                           name="user[quit_date]" id="user[quit_date]" placeholder="dd-mm-yyyy"
                           value="{{old('user.quit_date')? old('user.quit_date') : $applicant->quit_date}}">
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 align-self-center">
                <label class="label-sm hr-default-text">  Comments</label>
                <input type="text" class="form-control required info-required" name="user[comments]"
                       id="comments"
                       value="{{old('user.comments')? old('user.comments') : $applicant->comments}}"
                       autofocus>
            </div>
        </div>
        <div class="form-group row mt-5">
            <div class="col title mx-3">
                <b class="mb-4">Salary Info</b>
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text"> Actual Salary *</label>
                <input type="number" class="form-control "
                       value="{{old('user.actual_salary')? old('user.actual_salary') : $applicant->actual_salary}}"
                       id="actual_salary" name="user[actual_salary]" autofocus>
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text"> Required Salary *</label>
                <input type="number" class="form-control"
                       value="{{ old('user.required_salary') ? old('user.required_salary') : $applicant->required_salary}}"
                       name="user[required_salary]" id="mobile_phone" autofocus>
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text">Economic Offer *</label>
                <input type="number" class="form-control"
                       value="{{ old('user.economic_offer') ? old('user.economic_offer') : $applicant->economic_offer}}"
                       name="user[economic_offer]" id="economic_offer" autofocusme
                >
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text"> Comments</label>
                <input type="text" name="user[economic_comments]" class="form-control"
                       value="{{ old('user.economic_comments') ? old('user.economic_comments') : $applicant->economic_comments}}"
                       id="economic_comments" autofocus>
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text"> Response *</label>
                <select class="form-control required selectpicker" name="user[response]" id="response" required>
                    <option value="">Please select response</option>
                    @foreach ($economic_response as $response)
                        <option {{old('user.response') ? (old('user.response') == $response ? 'selected' : '') : ($applicant->response == $response ? 'selected' : '')}}
                                value="{{old('user.response')? old('user.response') : $response}}">{{$response}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="modal-footer mt-5">
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
        var scanFile = document.querySelector('#scan_edit');

        if (typeof cvFile.files[0] !== "undefined" && cvFile.files[0] !== null) {
            formData.append("user[cv_path]", cvFile.files[0]);
        }

        if (typeof scanFile.files[0] !== "undefined" && scanFile.files[0] !== null) {
            formData.append("user[form_path]", scanFile.files[0]);
        }

        $.each(data, function (key, input) {
            formData.append(input.name, input.value);
        });
        var url = '{{ route("module.interviews.update", ["id" => $applicant->id]) }}';

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
                            url : '{{route("module.interviews.load-table")}}',
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