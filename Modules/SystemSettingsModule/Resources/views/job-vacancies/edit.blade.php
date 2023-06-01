<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Edit Job Vacancy </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
{{--{{ Form::open([ 'route' => ['module.job-vacancies.update', $job_vacancy->id], 'method' => 'PUT']) }}--}}
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

        <div class="row">
            <div class="col">
                {{ Form::label('job_position', 'Job Position Title', ['class'=>'default-color pl-2']) }}
                {{ Form::text('job_position', $job_vacancy->position, array('class' => 'form-control', 'placeholder' => 'Enter job vacancy title...', 'required'=>'required', 'id' => 'job_position_title')) }}
            </div>
            <div class="col">
                {{ Form::label('expiration', 'Expire Date', ['class'=>'default-color pl-2']) }}
                <div class="input-group date date_start_date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                    <input type="text" class="form-control" value="{{$job_vacancy->expiration}}" id="job_position_expiration" name="expiration" required>
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <label for="jp_description" class="default-color pl-2">Description</label>
                <textarea name="description" id="jp_description" class="form-control requestDesc" rows="5">{{$job_vacancy->description}}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
    <button type="button" class="btn btn-primary btn-small" onclick="saveEditBtn({{$job_vacancy->id}})"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>
</div>
{{--{{ Form::close() }}--}}
