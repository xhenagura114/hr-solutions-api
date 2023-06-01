<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
//$experience = $applicant->interviewExperiences->first();
?>

<div class="modal-header">
    <h5 class="modal-title"> Evaluation for  <b>{{$applicant->first_name}} {{$applicant->last_name}}</b></h5>
</div>
<div class="modal-body">
    <form class="mt-5" role="form"   id="updateEstimation" enctype="multipart/form-data" data-parsley-validate="">
        {{ csrf_field() }}
        <input type="hidden" id="fid" value="{{$applicant->id}}">
        <div class="row mt-md-5 mb-4">
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
                <label class="label-sm hr-default-text">Firstname of Candidate:</label>
                <input type="text" class="form-control required info-required"
                       name="user[first_name]"
                       id="first_name_edit" readonly
                       value="{{$applicant->first_name}}">
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text">Lastname of Candidate:</label>
                <input type="text" class="form-control required info-required"
                       name="user[last_name]"
                       id="last_name_edit" readonly
                       value="{{$applicant->last_name}}">
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text">Possible Position:</label>
                <input type="text" class="form-control" name="user[possible_position]"
                       id="possible_position"
                       value="{{old('user.possible_position')? old('user.possible_position') : $applicant->possible_position}}">
            </div>


            <div class="col-lg-4 col-md-12 align-self-center">
                <label class="label-sm hr-default-text"> Seniority:</label>
                <input type="text" class="form-control" name="user[seniority]" id="seniority_edit"
                       value="{{old('user.seniority')? old('user.seniority') : $applicant->seniority}}">
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text">Price: (Salary- economic offer)</label>
                <input type="number" class="form-control info-required required"
                       value="{{ old('user.economic_offer') ? old('user.economic_offer') : $applicant->economic_offer}}"
                       name="user[economic_offer]" id="economic_offer" >
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label  class="label-sm hr-default-text"> Foreign Languages</label>
                <input type="text" class="form-control" name="user[languages]"
                       id="languages_edit"
                       value="{{old('user.languages')? old('user.languages') : $applicant->languages}}">
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-6 col-sm-12 align-self-center">
                <label class="label-sm hr-default-text"> Other (Soft Skills)</label>
                <textarea type="text" class="form-control mt-3" name="user[soft_skills]"
                          id="soft_skills" rows="10"
                          value="{{old('user.soft_skills')? old('user.soft_skills') : $applicant->soft_skills}}">{{$applicant->soft_skills}}</textarea>
            </div>
            <div class="col-md-6 col-sm-12 align-self-center">
                <label  class="label-sm hr-default-text">Description of Technical Evaluation:</label>
                <textarea name="user[technical_evaluation]" class="form-control mt-3" rows="10"
                          value="{{old('user.technical_evaluation')? old('user.technical_evaluation') : $applicant->technical_evaluation}}"
                          id="technical_evaluation_edit">{{$applicant->technical_evaluation}}</textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" formaction="{{ route('module.interviews.doc') }}" class="btn btn-small btn-secondary"><i class="fa fa-file-word-o"></i>&nbsp;Download</button>
            <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
            <button type="button" class="btn btn-small btn-success saveEstimation"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
        </div>
    </form>
</div>
<script>
    $(window).bind("load", function () {
        $('.spinnerBackground').fadeOut(500);
    });
    function saveEstimation() {
        var data = $("#updateEstimation").serializeArray();

        var formData = new FormData();

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
                    $('#estimationApplicantModal').modal('hide');
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
                    $(".estimationApplicantModal").html(response);
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

        $(".saveEstimation").on('click', function(){
            // saveData();
            $(this).parsley().validate();
            if($('#updateEstimation').parsley().isValid()) {
                saveEstimation();
            } else {
                setTimeout(function () {
                    $('#updateEstimation').parsley().validate();
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
