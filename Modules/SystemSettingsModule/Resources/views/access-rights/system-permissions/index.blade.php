@extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('header-scripts')
    {{--add here additional header scripts--}}

@endsection


@section('content')
    <div class="container-fluid">
        <div class="searchBar">
            <p>Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <div class="dataTables_length" id="table_length">
                    <input type="search" aria-controls="table" class="form-control hr-input" id="myInputTextField"
                           placeholder="Search">
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-12 search">
                <i class="fa fa-search hr-default-text"></i>
            </div>
        </div>
        <div class="hr-content pt-3 pb-5">
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

                <div class="row">
                    <div class="col">
                        <h5 class="hr-default-text mb-4">Permissions</h5>
                        <a href="{{ route('system-settings.access-rights.system-users.index') }}"
                           class="btn btn-default pull-right">Users</a>
                        <a href="{{ route('system-settings.access-rights.system-roles.index') }}"
                           class="btn btn-default pull-right">Roles</a>
                        <hr>
                        {!! Form::open([ 'route' => ['system-settings.access-rights.system-permissions.index'] ]) !!}
                        <div class="row mt-5 mb-5">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                {{ Form::text('name', '', array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Name')) }}
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12 align-self-end">
                                {{ Form::submit('Create', array('class' => 'btn btn-primary btn-small')) }}
                            </div>
                        </div>
                        {{ Form::close() }}

                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                <tr>
                                    <th>Permissions</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            {!! Form::button('<i class="fa fa-trash-o"></i>', ['class' => 'btn hr-outline btn-sm delete' , 'id' => $permission->id]) !!}
                                            <button class="btn hr-outline pull-right btn-sm edit" data-toggle="modal"
                                                    id={{$permission->id}}
                                                            data-target="#editSystemPermission"
                                                    onclick="editSystemUser({{ $permission->id }})"><i
                                                        class="fa fa-edit"></i></button>
                                        </td>
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
    <div id="editSystemPermission"
         class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content system-permissions-edit">
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


        $(function () {
            var tempRow;

            var oDataTable = $('#table').DataTable({
                "ordering": false
            });

            $('#myInputTextField').keyup(function () {
                oDataTable.search($(this).val()).draw();
            });

            //delete btn
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
                }).then(function(result) {
                    if(result.value)
                {
                    $.ajax({
                        contentType: "application/json",
                        url: "/system-settings/access-rights/system-permissions/delete/" + id,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
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
            })
            });


            $(".edit").click(function () {
                tempRow = $(this).parent().parent().find('td:first');
                // var currentElement = $(this).get(0);
                // var id = currentElement.attributes.id.value;
            });

        });

        //    edit modal
        function editSystemUser(user_id) {
            var url = '/system-settings/access-rights/system-permissions/' + user_id + '/edit';

            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $(".system-permissions-edit").html(data);
                    $("#editSystemPermission").modal('show');
                }
            });

        }

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

    </script>
@endsection