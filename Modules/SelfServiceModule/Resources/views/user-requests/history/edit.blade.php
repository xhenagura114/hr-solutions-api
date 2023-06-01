<form action="" class="modal-dialog"
      role="document" id="formRequest">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editRequestTitle">Edit leave request</h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">

                <div class="row mt-4">

                    <div class="col-md-6">
                        <Label for=user_id" class="hr-default-text label-sm">User Selected</Label>
                        <select class="form-control" required="required" id="reason" name="reason" disabled
                                style="-webkit-appearance: none">
                            <option>{{$user->first_name}} {{$user->last_name}}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('reason', 'Select Reason', ['class' => 'hr-default-text label-sm']) }}
                        <select class="form-control" required="required" id="reason" name="reason">
                            <option {{$request->reason == "VACATION" ? 'selected' : ''}} value="VACATION">VACATION
                            </option>
                            <option {{$request->reason == "PERSONAL" ? 'selected' : ''}} value="PERSONAL">PERSONAL
                            </option>
                            <option {{$request->reason == "SICK" ? 'selected' : ''}} value="SICK">SICK</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        {{ Form::label('start_date', 'From Date', ['class' => 'hr-default-text label-sm']) }}
                        <div class="input-group date date_start_date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" id="start_date" value="{{  $request->start_date }}" name="start_date" placeholder="dd-mm-yyyy" required >
                            <div class="input-group-addon calendar-icon">
                                <span class="fa fa-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('end_date', 'To Date', ['class' => 'hr-default-text label-sm']) }}
                        {{--{{Form::date('end_date', $request->end_date, array('class' => 'form-control', 'required'=>'required', 'min'=>''))}}--}}
                        <div class="input-group date date_end_date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" id="end_date" value="{{ $request->end_date }}" name="end_date" placeholder="dd-mm-yyyy" required>
                            <div class="input-group-addon calendar-icon">
                                <span class="fa fa-calendar"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 mb-5">
                    <div class="col-md-12">
                        <label for=description" class="hr-default-text pl-3">Description</label>
                        {{ Form::textarea('description', $request->description, array('class' => 'form-control requestDesc', 'placeholder' => 'Enter request description', 'rows' => '4')) }}
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12">
                        <label for='photo_path' class="hr-default-text pl-3">Attach report</label>
                        <div class="upload-file">
                            <input name="photo_path" id="photo_path" type="file"  class="form-control-file" enctype="multipart/form-data" multiple="multiple">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <input type="hidden" name="request_id" value="{{$request->id}}">
        <input type="hidden" name="user_id" value="{{$request->user_id}}">

        <div class="modal-footer">
            <button type="button" class="btn btn-small btn-secondary close-modal" data-dismiss="modal">
                Close
            </button>
            <button type="submit" class="btn btn-small btn-primary" id="editRequest">Save</button>
        </div>
    </div>
</form>

<script src="{{asset('js/moment.min.js')}}"></script>
<script>

    $('#editRequest').submit(function () {
        event.preventDefault();
        var str = $("#formRequest").serialize();
        var request = $.ajax({
            url: "{{route('module.requests.history-update')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: str,
            dataType: "json"
        });


        request.done(function (data) {
            swal({
                type: 'success',
                title: 'Your Request has been edited!',
                showConfirmButton: false,
                timer: 1000,
            }).then(function (result) {
                $.ajax({
                    method: "GET",
                    url : '{{route("module.requests.history-table-load")}}',
                    success : function (response) {
                        $("#loadTable").html(response)
                        $('#editRequest').modal('hide');

                    }
                });
            });

        });

        request.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    });
    $('.date_start_date').datepicker({
        startDate: new Date()
    });


</script>