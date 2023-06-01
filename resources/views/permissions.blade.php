<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/datatables.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/jquery-ui.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">

    <link rel="stylesheet" href="{{asset("css/custom.css")}}">

    <link rel="stylesheet" href="{{asset("css/theme.css")}}">

    <link rel="stylesheet" href="{{asset("css/main.css")}}">

    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">

    <script src="{{asset("js/jquery-3-3-1.min.js")}}"></script>

    <script src="{{asset("js/jquery-ui.min.js")}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

    <script src="{{asset("js/bootstrap.min.js")}}"></script>

    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>

    <style>
        .bootstrap-select .dropdown-menu.inner{
            max-height: 150px;
        }
    </style>

</head>
<body>
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col">
            <h3>Permission list</h3>
        </div>
    </div>
    <form action="{{ route("save.roles.role") }}" method="POST">
        {{ csrf_field() }}
        <div class="row">

            <div class="col-md-12">
                <input type="text" name="role[name]" placeholder="Role name">
            </div>

            @foreach($modules as $key => $module)
                <div class="col-4 mb-5">
                    <label class="hr-default-text"> {{ucfirst($key) }} </label>
                    <select class="selectpicker" data-live-search="true" multiple="multiple" name="role[permissions][]">
                        @foreach($module as $key => $permissions)
                            @if($key === "routes")
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission }}">
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
</body>
