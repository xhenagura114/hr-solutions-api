<script type="text/javascript">
    $('.selectpicker').selectpicker({});
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal-header">
    <h5 class="modal-title"> Edit Internship</h5>
</div>
<div class="modal-body">
    <form class="mt-5" role="form" id="updateInternship" enctype="multipart/form-data" data-parsley-validate="">
        {{ csrf_field() }}
        <input type="hidden" id="fid" value="{{$internship->id}}">
        <div class="row">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="first_name_edit" class="label-sm hr-default-text"> First Name *</label>
                <input type="text" class="form-control required info-required" name="first_name_edit"
                       id="first_name_edit"
                       value="{{old('first_name_edit')? old('first_name_edit') : $internship->first_name}}" autofocus
                       required="">
                @if ($errors->has('first_name_edit'))
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
                <input type="text" class="form-control required info-required" name="last_name_edit"
                       id="last_name_edit"
                       value="{{old('last_name_edit')? old('last_name_edit') : $internship->last_name}}"
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
                <label for="email_edit" class="label-sm hr-default-text"> Email</label>
                <input type="text" class="form-control info-required" name="email_edit"
                       id="email_edit"
                       value="{{old('email_edit')? old('email_edit') : $internship->email}}"
                       autofocus>
                @if ($errors->has('email_edit'))
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
                <label for="gender_edit" class="label-sm hr-default-text"> Gender</label>
                <select class="form-control required selectpicker" name="gender_edit" id="gender_edit">
                    <option value="">Please select gender</option>
                    @foreach ($gender_enum as $gen => $gender)
                        <option {{old('gender_edit') ? (old('gender_edit') == $gen ? 'selected' : '') : ($internship->gender == $gen ? 'selected' : '')}}
                                value="{{old('gender_edit')? old('gender_edit') : $gen}}">{{$gender}}</option>
                    @endforeach
                </select>
                @if ($errors->has('gender_edit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender_edit') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="contact_edit" class="label-sm hr-default-text"> Phone Number</label>
                <input type="text" class="form-control required info-required" name="contact_edit"
                       id="contact_edit"
                       value="{{old('contact_edit')? old('contact_edit') : $internship->contact}}"
                       autofocus>
                @if ($errors->has('contact_edit'))
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
                <label for="interests_edit" class="label-sm hr-default-text"> Interests</label>
                <select class="selectpicker" id="interests_edit" name="interests_edit[]" multiple title="Choose one of the following..." data-live-search="true" data-parsley-multiple="interests[]">
                    @if($internship->interests == NULL)
                        @php
                            $internship->interests = [];
                        @endphp
                    @endif
                    @foreach ($job_positions as $position_dropdown)
                        <option {{old('interests_edit') ? (in_array(old('interests_edit'), $internship->interests) ? 'selected' : '') : (in_array($position_dropdown->title, $internship->interests) ? 'selected' : '')}}
                                value="{{$position_dropdown->title}}">{{$position_dropdown->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-4 col-sm-12 align-self-center">
                <label for="institution_edit" class="label-sm hr-default-text">  Educational Institution</label>
                <input type="text" class="form-control required info-required" name="institution_edit"
                       id="institution_edit"
                       value="{{old('institution_edit')? old('institution_edit') : $internship->institution}}"
                       autofocus>
                @if ($errors->has('institution_edit'))
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
                <label for="education_edit" class="label-sm hr-default-text">  Level of Education</label>
                <select class="form-control required selectpicker" name="education_edit" id="education_edit">
                    <option value="">Please select Education</option>
                    @foreach ($enumoption as $education)
                        <option {{old('education_edit') ? (old('education_edit') == $education ? 'selected' : '') : ($internship->education == $education ? 'selected' : '')}}
                                value="{{old('education_edit')? old('education_edit') : $education}}">{{$education}}</option>
                    @endforeach
                </select>
                @if ($errors->has('education_edit'))
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
                <label for="studying_for_edit" class="label-sm hr-default-text">  Studying For</label>
                <input type="text" class="form-control required info-required" name="studying_for_edit"
                       id="studying_for_edit"
                       value="{{old('studying_for_edit')? old('studying_for_edit') : $internship->studying_for}}"
                       autofocus>
                @if ($errors->has('studying_for_edit'))
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
                <label for="comments_edit" class="label-sm hr-default-text">  Comments</label>
                <input type="text" class="form-control required info-required" name="comments_edit"
                       id="comments_edit"
                       value="{{old('comments_edit')? old('comments_edit') : $internship->comments}}"
                       autofocus>
                @if ($errors->has('comments_edit'))
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


    function saveData() {
        var data = $("#updateInternship").serializeArray();

        var formData = new FormData();


        $.each(data, function (key, input) {
            formData.append(input.name, input.value);
        });
        var url = '{{ route("module.internship.update", ["id" => $internship->id]) }}';

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response.status);
                if(response.status) {
                    $('#editInternshipModalModal').modal('hide');
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
                            url : '{{route("module.internship.load-table")}}',
                            success : function (response) {
                                $("#loadTable").html(response)
                                $('#editInternshipModal').modal('hide');

                            }
                        });
                    });
                } else {
                    $(".editInternshipModal").html(response);
                }
            },
            error: function (error) {
                console.log(error);
            }

        });
    }

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".saveUpdates").on('click', function(){
//            saveData();
             $(this).parsley().validate();
             if($('#updateInternship').parsley().isValid()) {
                 saveData();
             } else {
                 setTimeout(function () {
                     $('#updateInternship').parsley().validate();
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
