<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Edit API URL </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

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
                <label for="code" class="default-color pl-2">Organisation code</label>
                <input class="form-control hr-input" id="org_code" name="code" type="text" value="{{$apiUrl->code}}" placeholder="Enter organisation code" required>
                <label for="url" class="default-color pl-2">Organisation url</label>
                <input class="form-control hr-input" id="org_url" name="url" type="text" value="{{$apiUrl->url}}" placeholder="Enter organisation url" required>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-small btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>&nbsp;Close</button>
    <button type="button" class="btn btn-primary btn-small saveEditBtn" onclick="saveEditBtn({{$apiUrl->id}})"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>
</div>
