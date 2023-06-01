<script type="text/javascript">
    $('.selectpicker').selectpicker({});
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal-header">
    <h5 class="modal-title"> Edit Internship</h5>
</div>
<div class="modal-body">
    <form class="mt-5" role="form" id="updatePartner" enctype="multipart/form-data" data-parsley-validate="">
        {{ csrf_field() }}
        <input type="hidden" id="fid" value="{{$partner->id}}">
        <div class="row">
            <div class="col-md-3 col-sm-12 align-self-center">
                <label for="first_name_edit" class="label-sm hr-default-text"> First Name *</label>
                <input type="text" class="form-control required info-required" name="first_name_edit"
                       id="first_name_edit"
                       value="{{old('first_name_edit')? old('first_name_edit') : $partner->first_name}}" autofocus
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

            <div class="col-md-3 col-sm-12 align-self-center">
                <label for="last_name_edit" class="label-sm hr-default-text"> Last Name *</label>
                <input type="text" class="form-control required info-required" name="last_name_edit"
                       id="last_name_edit"
                       value="{{old('last_name_edit')? old('last_name_edit') : $partner->last_name}}"
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

            <div class="col-md-3 col-sm-12 align-self-center">
                <label for="birthday_edit" class="label-sm hr-default-text"> Birthday</label>
                <div class="input-group date" data-provide="datepicker"
                     data-date-format="dd-mm-yyyy">
                    <input type="text" class="form-control"
                           name="birthday_edit" id="birthday_edit"
                           value="{{old('birthday_edit')? old('birthday_edit') : $partner->birthday}}">
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
                @if ($errors->has('birthday_edit'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="col-md-3 col-sm-12 align-self-center">
                <label for="contact_edit" class="label-sm hr-default-text"> Phone Number</label>
                <input type="text" class="form-control required info-required" name="contact_edit"
                       id="contact_edit"
                       value="{{old('contact_edit')? old('contact_edit') : $partner->contact}}"
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
        </div>
        <div class="row mt-md-5 mb-4">
            <div class="col-md-3 col-sm-12 align-self-center">
                <label for="company_edit" class="label-sm hr-default-text">  Company</label>
                <input type="text" class="form-control" name="company_edit"
                       id="company_edit"
                       value="{{old('company_edit')? old('company_edit') : $partner->company}}"
                       autofocus>
                @if ($errors->has('company_edit'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="col-md-3 col-sm-12 align-self-center">
                <label for="job_position_edit" class="label-sm hr-default-text"> Job Position</label>
                <input type="text" class="form-control" name="job_position_edit"
                       id="studying_for_edit"
                       value="{{old('job_position_edit')? old('job_position_edit') : $partner->job_position}}"
                       autofocus>
                @if ($errors->has('job_position_edit'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="col-md-3 col-sm-12 align-self-center">
                <label for="email_edit" class="label-sm hr-default-text"> Email</label>
                <input type="text" class="form-control info-required" name="email_edit"
                       id="email_edit"
                       value="{{old('email_edit')? old('email_edit') : $partner->email}}"
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
        var data = $("#updatePartner").serializeArray();

        var formData = new FormData();


        $.each(data, function (key, input) {
            formData.append(input.name, input.value);
        });
        var url = '{{ route("module.partners.update", ["id" => $partner->id]) }}';

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status) {
                    $('#editPartnersModal').modal('hide');
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
                            url : '{{route("module.partners.load-table")}}',
                            success : function (response) {
                                $("#loadTable").html(response)
                                $('#editPartnersModal').modal('hide');

                            }
                        });
                    });
                } else {
                    $(".editPartnersModal").html(response);
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
             if($('#updatePartner').parsley().isValid()) {
                 saveData();
             } else {
                 setTimeout(function () {
                     $('#updatePartner').parsley().validate();
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