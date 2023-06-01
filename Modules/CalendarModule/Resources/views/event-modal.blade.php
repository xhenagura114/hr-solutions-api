<form role="form" id="form" method="POST" action="{{ route('module.calendar.create-event') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
<div id="eventModal">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <input type="text" name="title" id="title" class="addEventTitle" placeholder="Event name">
        </div>
        <div class="col-md-4 col-sm-12">
            <select name="categoryEvent" id="categoryEvent">
                <option value="">Select Category</option>
                @foreach($event_types as $event_type)
                    <option id="{{$event_type->id}}" value="{{$event_type->color}}">{{$event_type->type}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="upload-file">
                <input name="cv_path" id="cv_path" type="file"  accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
            </div>

        </div>
    </div>

    <div class="row">

    </div>
</div>

</form>
