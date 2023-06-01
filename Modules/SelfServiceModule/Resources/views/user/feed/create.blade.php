@extends('selfservicemodule::layouts.self-service-extendable',['pageTitle' => 'Self-Service'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <script src="{{ asset("js/parsley.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <script>tinymce.init({
            selector: '#body',
            plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen link table charmap hr pagebreak nonbreaking anchor toc insertdatetime lists textcolor wordcount contextmenu colorpicker',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true
        });
    </script>
    {{--add here additional header scripts--}}
@endsection

@section('content')



        <div class="create feed-page hr-content full-wrapper gray-bg">

            <div class="container-fluid  pt-5 pb-5 header-feed bg-blue">

                @if($currentUser->hasAccess(["module.self-service.feed-store", "module.self-service.feed"]))

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pl-4">
                        <h5 class="hr-default-text mb-4">Feed</h5>

                    </div>

                @endif
            </div>

            <div class="container-fluid white-bg d-in-block scroll-box pl-r-85">

                @if($currentUser->hasAccess(["module.self-service.feed-store", "module.self-service.feed"]))

                    @if(Session::has('flash_message'))
                        <div class="alert alert-success mt-3"><em> {!! session('flash_message') !!}</em>
                        </div>
                    @endif

                    <div class="create-form-block">
                        <div class="row mb-4  mt-4 title-row">
                            <div class="col">
                                <b class="hr-default-text large-space-title">Create new feed</b>
                            </div>
                        </div>

                        <form class="mt-5 mb-5 " role="form" id="form" method="POST"
                              action="{{ route('module.self-service.feed-store') }}" enctype="multipart/form-data"
                              data-parsley-validate="">
                            {{ csrf_field() }}

                            <div class="create-form-wraper">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12 align-self-top mb-5 {{ $errors->has('title') ? ' has-error' : '' }}">
                                                <label for="title" class="label-sm hr-default-text">Announcement title</label>
                                                <input type="text" name="title" class="form-control"
                                                       value="{{ old('title') }}" id="title" required="" autofocus>
                                                @if ($errors->has('title'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="col-lg-6 col-xs-12 align-self-top mb-5">
                                                <label for="users" class="label-sm hr-default-text">Users</label>

                                                <select id="users" name="users[]" class="selectpicker" data-actions-box="true" data-live-search="true" multiple="multiple" title="Please select users" data-parsley-multiple="users[]" >
                                                    @foreach ($users as $user)
                                                        <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12 align-self-top mb-5">
                                                <label for="departments" class="label-sm hr-default-text">Departments</label>
                                                <select id="departments" name="departments[]" class="selectpicker" data-actions-box="true" multiple title="Choose one of the following..." data-live-search="true" data-parsley-multiple="users[]">
                                                    @foreach ($departments as $department)
                                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-6 col-xs-12 align-self-center mb-5 {{ $errors->has('file') ? ' has-error' : '' }}" id="fileInputs">
                                                <!-- <div class="col-md-8 offset-2">
                                                    <label for="attachments" class="label-sm hr-default-text">You can select multiple files</label>&nbsp;&nbsp;
                                                    <input type="file" id="attachments" name="attachments[]" multiple>
                                                </div> -->


                                                <div class="upload-file">

                                                    <input type="file" id="attachments" class="input-file st-file" name="attachments[]" multiple>
                                                    <label for="attachments" class="light-hr-input cmp-training-file">
                                                        <span>You can select multiple files</span>
                                                        <strong class="pull-right">
                                                            <i class="fa fa-upload"></i>
                                                        </strong>
                                                    </label>
                                                </div>







                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12 align-self-top mb-5">
                                                <label for="email_notification" class="label-sm hr-default-text">
                                                    Email Notification
                                                    <input type="checkbox" name="email" value="1" id="email_notification"
                                                           switch="none"/>
                                                    <span class="c-switch-label"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-12  align-self-top  {{ $errors->has('body') ? ' has-error' : '' }}">
                                        <textarea name="body" id="body" cols="30" rows="10"></textarea>
                                        @if ($errors->has('body'))
                                            <span class="help-block">
                                             <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                        @endif
                                    </div>


                                </div>

                                <div class="row">

                                    <div class="col-lg-2 col-md-3 align-self-top mt-4">
                                        <button type="submit" class="btn btn-small blue-btn-create" id="save-btn"> Create
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </form>
                        <div class="row mt-3 mb-5 pl-1">
                            <div class="col" id="loadTable">
                            </div>
                        </div>


                    </div>

                @endif
            </div>
        </div>

@stop


@section('footer-scripts')
    {{--add here additional footer scripts--}}

    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

        $('#createFeedForm').submit(function () {
            $('#save-btn').attr('disabled', true);
            swal({
                title: 'Please Wait',
                onOpen: function () {
                    swal.showLoading()
                }
            }).then(function (result) {
                result.dismiss === swal.DismissReason.timer;
            });
        });
        $feedContents = $('.content.hideContent');

        $("#checkAll").click(function () {
             $('input:checkbox').not(this).prop('checked', this.checked);
         });
    </script>
@endsection
