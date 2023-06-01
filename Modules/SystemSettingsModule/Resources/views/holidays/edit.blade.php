<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Edit Holiday </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="container-fluid pt-3 mb-5">
        @if(Session::has('flash_message'))
            <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
            </div>
        @endif

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
            <div class="col align-self-center">
                {{ Form::label('title', 'Holiday Title', ['class'=>'default-color pl-2']) }}
                {{ Form::text('title', $holiday->title, array('class' => 'form-control', 'placeholder' => 'Enter holiday title...', 'required'=>'required', 'id'=>'edit_holiday_title')) }}
            </div>
        </div>
        <div class="row mt-4">

            <div class="col align-self-center">
                {{ Form::label('day', 'Day', ['class'=>'default-color pl-2']) }}
                <div class="input-group date date_start_date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control" value="{{$holiday->day}}" name="day" id="edit_day" placeholder="dd-MM-yyyy" required >
                    <div class="input-group-addon calendar-icon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
    <button type="button" class="btn btn-primary btn-small saveEditBtn" onclick="saveEditBtn({{ $holiday->id }})"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>
    <input id="month_day" type="hidden" name="month_day" value=""/>
</div>

<script type="text/javascript">
</script>
