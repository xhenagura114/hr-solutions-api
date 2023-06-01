@if($currentUser->hasAccess('module.api-urls.index'))
    @extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection


@section('content')
    <div class="container-fluid">
        <div class="searchBar">
            <p class="mb-0">Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <input type="text" class="form-control hr-input" id="myInputTextField">
            </div>
        </div>
        <div class="hr-content pt-3 pb-5">
            <div class="h-100 scroll">

                <div class="container-fluid">

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

                    <div class="row mb-4 pl-4">
                        <div class="col">
                            <h5 class="hr-default-text mb-4">API URLs</h5>
                        </div>
                    </div>
                    @if($currentUser->hasAccess(['module.api-urls.store']))
                        {{ Form::open([ 'route' => ['module.api-urls.store'], 'class' => 'row mt-5 mb-5 pl-4' ]) }}
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <label for="position" class="label-sm hr-default-text">Organization code</label>
                            {{ Form::text('code', '', array('class' => 'form-control', 'required'=>'required')) }}
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <label for="position" class="label-sm hr-default-text">Organization url</label>
                            {{ Form::text('url', '', array('class' => 'form-control', 'required'=>'required')) }}
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12 offset-lg-1 align-self-end">
                            {{ Form::submit('Add', array('class' => 'btn btn-primary btn-small align-self-center')) }}
                        </div>
                        {{ Form::close() }}
                    @endif

                    <div class="row mt-5 mb-2 pl-4">
                        <div class="col">
                            <table class="table" id="table">
                                <thead>
                                <tr>
                                    <th>Organization Code</th>
                                    <th>Organization URL</th>
                                    @if($currentUser->hasAnyAccess(['module.api-urls.edit', 'module.api-urls.update', 'module.api-urls.destroy']))
                                        <th>Operations</th>
                                    @endif
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($apiUrls as $apiUrl)
                                    <tr>
                                        <td class="table-code">{{$apiUrl->code}}</td>
                                        <td class="table-url">{{$apiUrl->url}}</td>
                                        @if($currentUser->hasAnyAccess(['module.api-urls.edit', 'module.api-urls.update', 'module.api-urls.destroy']))
                                            <td>
                                                @if($currentUser->hasAccess(['module.api-urls.destroy']))
                                                    {!! Form::button('<i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash-o"></i>', ['class' => 'btn btn-sm pull-right hr-outline delete', 'type' => 'button', 'id' => $apiUrl->id]) !!}
                                                @endif

                                                @if($currentUser->hasAccess(['module.api-urls.edit', 'module.api-urls.update']))
                                                    <button class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;"
                                                            data-toggle="modal" data-target="#apiUrlEdit"
                                                            onclick="editApiUrl('{{ $apiUrl->id }}', this)"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></button>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div id="apiUrlEdit"
         class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content api-url-edit">
            </div>
        </div>
    </div>

@endsection


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        var editedRow;
        $(function () {
            var oDataTable = $('#table').DataTable({
                "ordering": false
            });
            $('#myInputTextField').keyup(function () {
                oDataTable.search($(this).val()).draw();
            })

        });

        @if($currentUser->hasAccess(['module.api-urls.destroy']))
        $("table .delete").click(function () {
            var id = $(this).attr('id');
            var actionElement = $(this).parent();
            var cellElement = actionElement.parent();
            var rowElement = cellElement.get(0);
            swal({
                title: 'Are you sure?',
                text: "Do you want to delete this item",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result){
                if(result.value) {
                    $.ajax({
                        url: '/system-settings/api-urls/' + id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method: "POST",
                        data: {_method: "DELETE"},
                        dataType: "json",
                        success: function (result) {
                            if (result.status === 'success') {
                                rowElement.remove();
                                swal(
                                    'Deleted!',
                                    result.message,
                                    'success'
                                )
                            } else if (result.status === 'error') {
                                swal(
                                    'Error',
                                    result.message,
                                    'warning'
                                )
                            }

                        }
                    });
                }
            });
        });

        @endif

        @if($currentUser->hasAccess(['module.api-urls.edit', 'module.api-urls.update']))

        function editApiUrl(id, _this) {

            var url = '/system-settings/api-urls/' + id + '/edit';

            editedRow = $(_this).parent().parent();
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $(".api-url-edit").html(data);
                    $("#apiUrlEdit").modal('show');
                }
            });

        }

        function saveEditBtn(id) {
            var code = $('#org_code').val();
            var url = $('#org_url').val();
            $.ajax({
                url: "/system-settings/api-urls/" + id,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "POST",
                dataType: 'json',
                data: {code: code, url: url, _method: "PUT"},
                success: function (response) {
                    if (response.status == 'success') {
                        var table_code = $(editedRow).find('.table-code')[0];
                        var table_url = $(editedRow).find('.table-url')[0];
                        $(table_code).text(code);
                        $(table_url).text(url);
                        $('#apiUrlEdit').modal('toggle');
                    }
                    swal({
                        type: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            });
        }

        @endif

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);


    </script>
@endsection
@endif
