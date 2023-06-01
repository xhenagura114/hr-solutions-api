<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Edit Position </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

{{--{{ Form::open([ 'route' => ['system-settings.positions.update', $position->id], 'method' => 'PUT' ]) }}--}}
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
                <label for="position" class="default-color pl-2">Position title</label>
                <input class="form-control hr-input" id="position-title" name="position" type="text" value="{{$position->title}}" placeholder="Enter job position title" required>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
    <button type="button" class="btn btn-primary btn-small saveEditBtn" onclick="saveEditBtn({{$position->id}})"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>
</div>
{{--{{ Form::close() }}--}}
