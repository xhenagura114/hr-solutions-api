@if($currentUser->hasAccess('module.general-settings.index'))
    @extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection


@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-5 pb-5 full-wrapper">

            <div class="container-fluid pl-5">

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

                @if($currentUser->hasAccess('module.general-settings.update'))
                    {{ Form::open([ 'route' => ['module.general-settings.update', $settings->id], 'method' => 'PUT', 'enctype' => "multipart/form-data" ]) }}

                    <div class="row ">
                        <div class="col">
                            <h5 class="hr-default-text mb-4">Visual</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-xl-2 align-self-end">
                            <label class="hr-default-text " for="email_edit">Upload logo</label>
                            {{--                    <input type="file" value="{{$settings->logo_path}}" name="logo" id="logo" class="form-control">--}}
                            <div class="upload-file">
                                <input id="logo" type="file" class="input-file"
                                       name="logo" value="{{$settings->logo_path}}" accept="image/*">
                                <label for="logo" class="light-hr-input">
                                    <span>Upload file</span>
                                    <strong class="pull-right"> <i class="fa fa-upload"></i></strong>
                                </label>
                            </div>
                        </div>
                        <div class="col pl-5">
                            <img id="logo_prev" src="{{asset($settings->logo_path)}}" alt="">
                        </div>

                    </div>
                    <div class="row system-email">
                        <div class="col-lg-3 col-xl-2">
                            <label class="hr-default-text " for="email_edit">System e-mail</label>
                            <input class="form-control" name="system_email"
                                   value="{{$settings->system_email}}"
                                   placeholder="Enter system email"/>
                        </div>
                    </div>

                    {{--<div class="row system-email">--}}
                    {{--<div class="col-lg-3 col-xl-2">--}}
                    {{--<label class="hr-default-text">Switch to dark mode</label>--}}
                    {{--</div>--}}

                    {{--@if($currentUser->hasAccess(["module.template.dark-mode"]))--}}
                    {{--<div class="col-lg-3 col-xl-2 pl-5">--}}
                    {{--<label for="dark_mode">--}}
                    {{--<input type="checkbox" name="dark_mode" value="1" id="dark_mode"--}}
                    {{--{{$settings->dark_mode ? 'checked' : ''}} switch="none"/>--}}
                    {{--<span class="c-switch-label"></span>--}}
                    {{--</label>--}}
                    {{--</div>--}}
                    {{--@endif--}}

                    {{--</div>--}}

                    {{--<div class="row mt-5">--}}
                    {{--<div class="col-lg-3 col-xl-2">--}}
                    {{--<label class="hr-default-text">Theme</label>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row mt-4">--}}
                    {{--<div class="col radio">--}}
                    {{--<label class="radio-inline mr-5"><input type="radio" value="1"--}}
                    {{--{{$settings->theme_path == 1 ? 'checked':''}} name="theme">--}}
                    {{--<span class="radio-label theme-1"></span>--}}
                    {{--</label>--}}
                    {{--<label class="radio-inline mr-5"><input type="radio" value="2"--}}
                    {{--{{$settings->theme_path == 2 ? 'checked':''}} name="theme">--}}
                    {{--<span class="radio-label theme-2"></span>--}}
                    {{--</label>--}}
                    {{--<label class="radio-inline mr-5"><input type="radio" value="3"--}}
                    {{--{{$settings->theme_path == 3 ? 'checked':''}} name="theme">--}}
                    {{--<span class="radio-label theme-3"></span>--}}
                    {{--</label>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="row mt-5">
                        <div class="col action-btn">
                            {{ Form::submit('Save', array('class' => 'btn btn-small btn-success')) }}
                        </div>
                    </div>

                    {{ Form::close() }}
                @endif


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
    </script>
    <script>
        //    preview img
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#logo_prev').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        {{--upload file input--}}
        $('.input-file').click(function () {
            var $input = $(this),
                $label = $input.next('label'),
                labelVal = $label.html();

            $input.on('change', function (e) {
                var fileName = '';
                if (e.target.value) {
                    fileName = e.target.value.split('\\').pop();
                }
                if (fileName)
                    $label.find('span').html(fileName);
                else
                    $label.html(labelVal);
            });
            $input
                .on('focus', function () {
                    $input.addClass('has-focus');
                })
                .on('blur', function () {
                    $input.removeClass('has-focus');
                });
        });

        $("#logo").change(function () {
            readURL(this);
        });

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);
    </script>
@endsection
@endif