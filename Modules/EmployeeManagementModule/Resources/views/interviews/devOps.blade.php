<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
//$experience = $applicant->interviewExperiences->first();
?>

<div class="modal-header">
    <h5 class="modal-title">DEVOPS FORM=><b>{{ $applicant->first_name }} {{ $applicant->last_name }}</b></h5>
</div>
<div class="modal-body">
    <form class="mt-5" role="form" id="updateDevOps"  enctype="multipart/form-data" data-parsley-validate="">
        {{ csrf_field() }}
        <input type="hidden" id="fid" name="preliminary_form_interview" value="{{$applicant->id}}">
        <div class="row mt-md-5 mb-4">
            <div class="col-md-6 col-sm-12 align-self-center">
                <label for="email_edit" class="label-sm hr-default-text"> Actual Company *</label>
                <input type="text" class="form-control" name="user[actual_company]"
                       id="actual_company_edit"
                       value="{{old('user.actual_company')? old('user.actual_company') : $applicant->actual_company}}"
                       autofocus required="">
            </div>
            <div class="col-md-6 col-sm-12 align-self-center">
                <label for="job_position_edit" class="label-sm hr-default-text">Actual position *</label>
                <input type="text" class="form-control" name="user[actual_position]"
                       id="actual_position_edit"
                       value="{{old('user.actual_position')? old('user.actual_position') : $applicant->actual_position}}"
                       required="">
            </div>
        </div>
        @php
            $categoryNames = array('System Administrator' => 'System Administrator',
            'Dev-OPS' => 'Dev-OPS',
              'Other DevOps' => 'Other (Specify)');

        @endphp
        <div class="row mt-md-3 mb-4 mx-2">
            <h5 class="my-4 dev-form-header">Professional Experience</h5>
            <div class="header-container">
                <div class="col-md-3 align-self-center">
                    <h6>System/Technology (version)</h6>
                </div>
                <div class="col-md-3 align-self-center">
                    <h6>Months of Experience</h6>
                </div>
                <div class="col-md-3 align-self-center">
                    <h6>Level (Indicated from 1-5)</h6>
                </div>
                <div class="col-md-3 align-self-center">
                    <h6>Seniority</h6>
                </div>
            </div>
            <div class="list-container">
                @foreach ($skillCategories as $cat)
                    @php
                        $catKey = array_search($cat->id, array_column($applicant->skills->toArray(), 'id'));
                    @endphp
                    <div class="technology <?php if($cat->mainCategory == 'Other DevOps') { echo 'other-techno'; } ?>">
                        @if($cat->mainCategory == 'Other DevOps')
                            <div class="col-md-12">
                                <input type="checkbox" class="input-techno" {{old('experience') ? (in_array(old('experience'), array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '') : (in_array($cat->id, array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '')}}
                                value="{{$cat->id}}" name="experience[]" id="{{$cat->mainCategory}}"/>
                                <label class="ml-1" for="{{$cat->mainCategory}}">{{$categoryNames[$cat->mainCategory]}}</label>
                            </div>
                            <div class="col-md-12 px-0">
                                <div class="col-md-3 p-0">
                                    <input type="text" readonly class="w-100" id="other_category" name="other_category[{{$cat->id}}][]" value = {{ $catKey !== false ? $applicant->skills->toArray()[$catKey]['pivot']['other_technology'] : "" }}>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" readonly class="month-experience" id="month_of_experience_category" name="month_of_experience_category[{{$cat->id}}][]" value = {{ $catKey !== false ? $applicant->skills->toArray()[$catKey]['pivot']['month_of_experience'] : "" }}>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" min="1" max="5" readonly id="level_category" name="level_category[{{$cat->id}}][]" value = {{ $catKey !== false ? $applicant->skills->toArray()[$catKey]['pivot']['level'] : "" }}>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" readonly class="seniority-category" id="seniority_category" name="seniority_category[{{$cat->id}}][]" value = {{ $catKey !== false ? $applicant->skills->toArray()[$catKey]['pivot']['seniority'] : "" }}>
                                </div>
                            </div>
                        @else
                            <div class="col-md-3">
                                <input type="checkbox" class="input-techno" {{old('experience') ? (in_array(old('experience'), array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '') : (in_array($cat->id, array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '')}}
                                value="{{$cat->id}}" name="experience[]" id="{{$cat->mainCategory}}"/>
                                <label class="ml-1" for="{{$cat->mainCategory}}">{{$categoryNames[$cat->mainCategory]}}</label>
                            </div>
                            <div class="col-md-3">
                                <input type="number" readonly class="month-experience" id="month_of_experience_category" name="month_of_experience_category[{{$cat->id}}][]" value = {{ $catKey !== false ? $applicant->skills->toArray()[$catKey]['pivot']['month_of_experience'] : "" }}>
                            </div>
                            <div class="col-md-3">
                                <input type="number" min="1" max="5" readonly id="level_category" name="level_category[{{$cat->id}}][]" value = {{ $catKey !== false ? $applicant->skills->toArray()[$catKey]['pivot']['level'] : "" }}>
                            </div>
                            <div class="col-md-3">
                                <input type="text" readonly class="seniority-category" id="seniority_category" name="seniority_category[{{$cat->id}}][]" value = {{ $catKey !== false ? $applicant->skills->toArray()[$catKey]['pivot']['seniority'] : "" }}>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row mt-md-5 mb-4 mx-2">
            <h5 class="dev-form-header mb-0">Technology Experience</h5>
            @foreach ($skillCategories as $cat)
                <h6 class="dev-form-header w-100">{{$cat->mainCategory}}</h6>
                <div class="header-container">
                    <div class="col-md-3 align-self-center">
                        <h6>System/Technology (version)</h6>
                    </div>
                    <div class="col-md-3 align-self-center">
                        <h6>Months of Experience</h6>
                    </div>
                    <div class="col-md-3 align-self-center">
                        <h6>Level (Indicated from 1-5)</h6>
                    </div>
                    <div class="col-md-3 align-self-center">
                        <h6>Seniority</h6>
                    </div>
                </div>
                <div class="list-container">
                    @foreach ($skills as $skill)
                        @if($skill->mainCategory == $cat->mainCategory)
                            @php
                                $skillKey = array_search($skill->id, array_column($applicant->skills->toArray(), 'id'));
                            @endphp
                            <div class="technology <?php if($skill->title == 'Other') { echo 'other-techno'; } ?>">
                                @if($skill->title == 'Other')
                                    <div class="col-md-12">
                                        <input type="checkbox" class="input-techno"  {{old('skills_edit') ? (in_array(old('skills_edit'), array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '') : (in_array($skill->id, array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '')}}

                                        value="{{$skill->id}}" id="skills_edit" name="skills_edit[]">
                                        <label for="{{$skill->title}}">{{ $skill->title == 'Other' ? 'Other (Specify)' : $skill->title }}</label>
                                    </div>
                                    <div class="col-md-12 px-0">
                                        <div class="col-md-3 p-0">
                                            <input type="text" readonly class="w-100" id="other_technology" name="other_technology[{{$skill->id}}][]" value = {{ $skillKey !== false ? $applicant->skills->toArray()[$skillKey]['pivot']['other_technology'] : "" }}>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" readonly class="month-experience" id="month_of_experience" name="month_of_experience[{{$skill->id}}][]" value = {{ $skillKey !== false ? $applicant->skills->toArray()[$skillKey]['pivot']['month_of_experience'] : "" }}>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" min="1" max="5" readonly onkeyup=inputMinMaxLevel(this) id="level" name="level[{{$skill->id}}][]" value = {{ $skillKey !== false ? $applicant->skills->toArray()[$skillKey]['pivot']['level'] : "" }}>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" readonly class="seniority-category" id="seniority" name="seniority[{{$skill->id}}][]" value = {{ $skillKey !== false ? $applicant->skills->toArray()[$skillKey]['pivot']['seniority'] : "" }}>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-3">
                                        <input type="checkbox" class="input-techno"  {{old('skills_edit') ? (in_array(old('skills_edit'), array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '') : (in_array($skill->id, array_column($applicant->skills->toArray(), 'id')) ? 'checked' : '')}}

                                        value="{{$skill->id}}" id="skills_edit" name="skills_edit[]">
                                        <label for="{{$skill->title}}">{{ $skill->title == 'Other' ? 'Other (Specify)' : $skill->title }}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" readonly class="month-experience" id="month_of_experience" name="month_of_experience[{{$skill->id}}][]" value = {{ $skillKey !== false ? $applicant->skills->toArray()[$skillKey]['pivot']['month_of_experience'] : "" }}>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" min="1" max="5" readonly  onkeyup=inputMinMaxLevel(this) id="level" name="level[{{$skill->id}}][]" value = {{ $skillKey !== false ? $applicant->skills->toArray()[$skillKey]['pivot']['level'] : "" }}>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" readonly class="seniority-category" id="seniority" name="seniority[{{$skill->id}}][]" value = {{ $skillKey !== false ? $applicant->skills->toArray()[$skillKey]['pivot']['seniority'] : "" }}>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                    @endforeach
                </div>
        </div>
        <div class="col-12 modal-footer mt-4">
            <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
            <button type="button" class="btn btn-small btn-success saveDevOps"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
        </div>
    </form>
</div>
<script>
    $(window).bind("load", function () {
        $('.spinnerBackground').fadeOut(500);
    });

    function saveDevOpsData() {
        var data = $("#updateDevOps").serializeArray();

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
                    $('#devOpsApplicantModal').modal('hide');
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
                    $(".devApplicantModal").html(response);
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

        $(".saveDevOps").on('click', function(){
            // saveData();
            $(this).parsley().validate();
            if($('#updateDevOps').parsley().isValid()) {
                saveDevOpsData();
            } else {
                setTimeout(function () {
                    $('#updateDevOps').parsley().validate();
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

    $('.input-techno').each(function() {
        if($(this).is(':checked')) {
            $(this).parents('.technology').find('input[type="number"]').attr("readonly", false);
            $(this).parents('.technology').find('input[type="text"]').first().attr("readonly", false);
        } else {
            $(this).parents('.technology').find('input[type="number"]').attr("readonly", true);
            $(this).parents('.technology').find('input[type="text"]').first().attr("readonly", true);
        }
    });

    $('.input-techno').on('click', function() {
        if($(this).is(':checked')) {
            $(this).parents('.technology').find('input[type="number"]').attr("readonly", false);
            $(this).parents('.technology').find('input[type="text"]').first().attr("readonly", false);
        } else {
            $(this).parents('.technology').find('input[type="number"]').attr("readonly", true);
            $(this).parents('.technology').find('input[type="text"]').first().attr("readonly", true);
        }
    });

    $('.month-experience').bind('keyup', function() {
        var seniority = getSeniority($(this).val());
        $(this).parents('.technology').find('.seniority-category').val(seniority);
    });

    function getSeniority(number) {
        if(number == '') {
            return '';
        }
        if(number < 24) {
            return 'Junior';
        }
        if(number >= 24 && number < 48) {
            return 'Intermediate';
        }
        if(number > 48) {
            return 'Senior';
        }
    }

</script>