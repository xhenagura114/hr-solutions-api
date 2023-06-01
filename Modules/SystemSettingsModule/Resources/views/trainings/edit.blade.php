<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Edit Training </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

{{--{{ Form::open([ 'route' => ['module.trainings.update', $training->id], 'method' => 'PUT' ]) }}--}}
<form role="form" id="editTraining" enctype="multipart/form-data">
<div class="modal-body">
    <div class="container-fluid pt-3 mb-5">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mt-4">
            <div class="col align-self-center">
                {{ Form::label('training_title', 'Training title', ['class'=>'default-color pl-2']) }}
                {{ Form::text('training_title', $training->title, array('class' => 'form-control', 'placeholder' => 'Enter training title...', 'required'=>'required', 'id'=> 'training-title')) }}
            </div>

            <div class="col align-self-center">
                <label for="training_title" class="default-color pl-2">Department</label>
                {{ Form::select('department_id', $departments->pluck('name', 'id'), $training->departments->id, array('class' => 'form-control selectpicker', 'required'=>'required', 'data-live-search' => 'true', 'id'=>'training_dept')) }}
            </div>

        </div>
        <div class="row mt-4">
            <div class="col align-self-center">
                {{ Form::label('start_date', 'Start Date', ['class'=>'default-color pl-2']) }}
                {{--{{Form::date('start_date', $training->start_date, array('class' => 'form-control', 'id'=> 'training-start-date'))}}--}}
                <div class="input-group date date_start_date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                    <input type="text" class="form-control" value="{{$training->start_date}}" id="training-start-date" name="start_date" placeholder="dd-mm-yyyy" onchange="setMinDateEdit()" required>
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
            <div class="col align-self-center">
                {{ Form::label('end_date', 'End Date', ['class'=>'default-color pl-2']) }}
                {{--{{Form::date('end_date', $training->end_date, array('class' => 'form-control', 'id'=> 'training-end-date'))}}--}}
                <div class="input-group date date_end_date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                    <input type="text" class="form-control" value="{{$training->end_date}}" id="training-end-date" placeholder="dd-mm-yyyy" name="end_date" required>
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <label for="" class="default-color pl-2">Upload file</label>
                <div class="upload-file">
                    <input id="uploadTrainingFile" type="file" class="input-file training_file" name="training_file" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
                    <label for="uploadTrainingFile" class="light-hr-input">
                        <span>{{ trans("label.upload_file") }}</span>
                        <strong class="pull-right">
                            <i class="fa fa-upload"></i>
                        </strong>
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col align-self-center">
                <label for="edit_training_description" class="default-color pl-2">Description</label>
                <textarea name="training_description" id="edit_training_description" class="form-control requestDesc" rows="5">{{$training->training_description}}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
    <button type="button" class="btn btn-primary btn-small" onclick="saveEditBtn({{$training->id}})"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>

</div>
</form>
{{--{{ Form::close() }}--}}

<script>

    function setMinDateEdit() {
        $("#training-end-date").val('');
        var $endDate = $('.date_end_date');

        $endDate.datepicker('destroy');
        $endDate.datepicker({
            startDate: $("#training-start-date").val(),
            format: 'dd-mm-yyyy'
        });
    }

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

    $('.input-file').click(function () {
        setFileNameOnUpload($(this));
    });

    $(".selectpicker").selectpicker();
</script>
