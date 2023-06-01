@extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>

@endsection


@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-5 pb-5 full-wrapper">
            <div class="h-100 scroll">
                <div class="container-fluid access-control">
                    {{--<div class="row mb-4">--}}
                    {{--<div class="col">--}}
                    {{--<h4 class="hr-default-text mb-4">Access Rights</h4>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="row">
                        <div class="col">
                            <h5 class="hr-default-text">Register roles</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                {{--<div class="card-header">--}}
                                {{--Register roles--}}
                                {{--</div>--}}
                                <div class="card-body">
                                    <form action="{{ route('module.roles.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <label for="" class="hr-default-text">Name</label>
                                                <input type="text" class="form-control" name="role[name]" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <button type="submit" class="btn btn-small btn-primary">Add Role</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col mt-4">
                                    <table class="table" id="table">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($roles as $role)
                                            <tr id="{{$role->id}}_tr">
                                                <td>{{$role->name}}</td>
                                                <td>{{$role->slug}}</td>
                                                <td>
                                                    <button class="btn pull-right hr-outline btn-sm delete"
                                                            id="{{ $role->id }}_delete" onclick="deleteRole(this)">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>

                                                    <a href="{{ route("module.roles.edit", ["id" => $role->id]) }}"
                                                       class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-5">
                        <div class="col">
                            <h5 class="hr-default-text"> Assign role to Users</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        {{--<div class="col-4">--}}
                        {{--<div class="card">--}}
                        {{--<div class="card-header">--}}
                        {{--Assign Users--}}
                        {{--</div>--}}
                        {{--<div class="card-body">--}}
                        {{--<form action="{{ route('module.roles.set-user-role') }}" method="POST">--}}
                        {{--@csrf--}}
                        {{--@method("put")--}}
                        {{--<div class="row">--}}
                        {{--<div class="col">--}}
                        {{--<label for="" class="hr-default-text">User</label>--}}
                        {{--<select class="selectpicker" name="user" data-live-search="true">--}}
                        {{--@foreach($users as $user)--}}
                        {{--<option value="{{ $user->id }}">--}}
                        {{--{{ $user->first_name }}--}}
                        {{--{{ $user->last_name }}--}}
                        {{--</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row mt-5">--}}
                        {{--<div class="col">--}}
                        {{--<label for="" class="hr-default-text">Roles</label>--}}
                        {{--<select class="selectpicker" name="role" data-live-search="true">--}}
                        {{--@foreach($roles as $role)--}}
                        {{--<option value="{{$role->id }}">--}}
                        {{--{{ $role->name }}--}}
                        {{--</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row mt-4">--}}
                        {{--<div class="col">--}}
                        {{--<button type="submit" class="btn btn-small btn-primary">Assign Role</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</form>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-12">
                            <div class="row card-body">
                                <div class="col-4">
                                    <label for="" class="hr-default-text">Search Employee</label>
                                    <input type="text" class="form-control" id="employeeSearch"/>
                                </div>
                            </div>
                            <table class="table" id="usersTable">
                                <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Role</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($usersWithRoles as $user)
                                    <tr>
                                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                                        <td>
                                            @if(isset($roles))
                                                <select class="selectpicker" data-live-search="true" onchange="changeRole({{ $user->id }}, this)">
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ $user->roles->first()->id === $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <script>
                                                    $('.selectpicker').selectpicker();
                                                </script>
                                            @endif
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
@endsection
@section('footer-scripts')
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });


        $(function () {
            var oDataTable = $('#table').DataTable({
                "ordering": false
            });

            var usersTable = $('#usersTable').DataTable({
                "ordering": false
            });
            $('#employeeSearch').on('keyup', function () {
                usersTable.search(this.value).draw();
            });
        })


        function deleteRole(element) {
            var id = parseInt(element.getAttribute("id"));
            swal({
                title: 'Are you sure?',
                text: "Do you want to delete this role",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if(result.value) {
                    $.ajax({
                        method: 'DELETE',
                        url: '{{ route("module.roles.destroy") }}/' + id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            "_method": 'DELETE'
                        },
                        success: function (response) {
                            if (response.success) {
                                $("#" + id + "_tr").remove();
                            }
                        }
                    });
                }
            });
        }

        function changeRole(userId, element) {
            var roleId = parseInt(element.value);
            $.ajax({
                method: 'POST',
                url: '{{ route("module.roles.set-user-role") }}',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    "_method": 'PUT',
                    "user": userId,
                    "role": roleId,
                },
                success: function (response) {
                    if (response.success) {
                        //Show sweet alert
                    }
                }
            })
        }
    </script>
@endsection
