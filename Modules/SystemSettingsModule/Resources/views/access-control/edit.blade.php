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

<style>
    .bootstrap-select .dropdown-menu.inner {
        max-height: 150px;
    }
</style>

<?php
    $data = isset($role) ? $role : $user;
?>

@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-4 pb-4 full-wrapper">
            <div class="h-100 scroll">

                <div class="container">
                    <div class="row mt-2 mb-2">
                        <div class="col">
                            <h3 class="hr-default-text">Permission list {{ isset($role) ? $role->name : $user->first_name . " " . $user->last_name }}</h3>
                        </div>
                    </div>
                    <form action="{{ isset($role) ? route("module.roles.update", ["id" => $role->id]) : route("module.roles.permissions-update", ["id" => $user->id])  }}" method="POST">
                        @method("put")
                        @csrf
                        <div class="row">
                            @foreach($modules as $key => $module)
                                <div class="col-4 mb-5 access-roles">
                                    <label class="hr-default-text"> {{ucfirst($key) }} </label>
                                    <select class="selectpicker" data-live-search="true" multiple="multiple"
                                            name="role[permissions][]" data-actions-box="true">
                                        @foreach($module as $key => $permissions)
                                            @if($key === "routes")
                                                @foreach($permissions as $permission)
                                                    <option value="{{ $permission }}" {{ (array_key_exists($permission, $data->permissions) && $data->permissions[$permission] === true) ? 'selected' : '' }}>
                                                        {{ explode(".", $permission )[2] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            @endforeach

                            <div class="col-md-12">
                                <input type="submit" class="btn btn-md btn-success">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });
    </script>
@endsection
