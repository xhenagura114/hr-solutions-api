@extends('selfservicemodule::layouts.self-service-extendable',['pageTitle' => 'Self-Service'])
<script src="{{asset('js/popper.min.js')}}"></script>
@section('header-scripts')
    <style>
    .test-eff {
        display: block!important;
    }
    </style>
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
{{--{{ error_reporting(0) }}--}}
    <div class="feed-page hr-content full-wrapper gray-bg">

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
                    <ul class="nav nav-pills filter-btn-group">
                        @if($currentUser->hasAccess("module.self-service.feed"))
                        <li class="nav-item">
                            <button type="button" class="btn btn-sm btn-primary active" data-toggle="tab" data-target="#allFeed">
                                All
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="tab" data-target="#departmentFeed">
                                Department
                            </button>
                        </li>
                        @endif
                        <li class="nav-item">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="tab" data-target="#personalFeed">
                                Personal
                            </button>
                        </li>
                    </ul>
                </div>
            @endif
        </div>

        <div class="container-fluid white-bg d-in-block scroll-box">
            @if(Session::has('flash_message'))
                <div class="alert alert-success mt-3"><em> {!! session('flash_message') !!}</em></div>
            @endif

            <div class="container">
                <div class="tab-content mt-5">
                    <div class="tab-pane fade active show" id="allFeed">
                        @if($currentUser->hasAccess("module.self-service.feed"))
                        <div class="list-posts row user-feed"></div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="departmentFeed">
                        @if($currentUser->hasAccess("module.self-service.feed"))
                        <div class="list-posts row user-feed"></div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="personalFeed">
                        <div class="list-posts row user-feed"></div>
                    </div>
                </div>

                <div id="loader" style="display: none">Please wait...</div>
            </div>
        </div>
    </div>

@stop


@section('footer-scripts')
    {{--add here additional footer scripts--}}

    <script src="{{asset('js/masonry.min.js')}}"></script>


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
                onOpen: function(){
                    swal.showLoading()
                }
            }).then(function(result){
                result.dismiss === swal.DismissReason.timer;
            });
        });
        $feedContents = $('.content.hideContent');


        // Tooltips
        $('.tip').each(function () {
            $(this).tooltip({
                html: true,
                title: $('#' + $(this).data('tip')).html(),
                trigger: "click"
            });
        });


        $('body').on('click', function (e) {
            $('[data-toggle=popover]').each(function () {

                // hide any open popovers when the anywhere else in the body is clicked
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.tooltip').has(e.target).length === 0) {
                    $(this).tooltip('hide');
                }
            });
        });


        var page = page_personal = page_department = 1,
            lastPage = lastPage_personal = lastPage_department = 0,
            is_loading = true;


        fetchData('{{route("module.self-service.all-feeds")}}?page=', page).done(function(response) {
            for(var i = 0; i < (response.data).length; i++) {
                var file = false;
                if(response.data[i].attachments) {
                    file = '{{route('module.self-service.feed-download')}}?path='+response.data[i].attachments[0].path;
                }
                $(".test-eff").fadeIn("slow");
                $("#allFeed .list-posts").append(renderPosts((response.data)[i], file));
            }
            lastPage = response.last_page;
        });
        fetchData('{{route("module.self-service.feed-personal")}}?page=', page_personal).done(function(response) {
            for(var i = 0; i < (response.data).length; i++) {
                var file = false;
                if(response.data[i].attachments) {
                    file = '{{route('module.self-service.feed-download')}}?path='+response.data[i].attachments[0].path;
                }
                $(".test-eff").fadeIn("slow");
                $("#personalFeed .list-posts").append(renderPosts((response.data)[i]));
            }
            lastPage_personal = response.last_page;
        });
        fetchData('{{route("module.self-service.feed-department")}}?page=', page_department).done(function(response) {
            for(var i = 0; i < (response.data).length; i++) {
                var file = false;
                if(response.data[i].attachments) {
                    file = '{{route('module.self-service.feed-download')}}?path='+response.data[i].attachments[0].path;
                }
                $(".test-eff").fadeIn("slow");
                $("#departmentFeed .list-posts").append(renderPosts((response.data)[i]));
            }
            lastPage_department = response.last_page;
        });


        $(".scroll-box").on("scroll", checkScroll);

        function checkScroll(e) {
            var elem = $(e.currentTarget),
                last_page = lastPage,
                active_page = 1,
                url = '{{route("module.self-service.all-feeds")}}',
                placer = $("#allFeed .list-posts");

            var active_tab = $(".filter-btn-group").find(".btn.active").data("target");
            switch (active_tab) {
                case '#personalFeed':
                    last_page = lastPage_personal;
                    page_personal++;
                    active_page = page_personal;
                    url = '{{route("module.self-service.feed-personal")}}';
                    placer = $("#personalFeed .list-posts");
                    break;
                case '#departmentFeed':
                    last_page = lastPage_department;
                    page_department++;
                    active_page = page_department;
                    url = '{{route("module.self-service.feed-department")}}';
                    placer = $("#departmentFeed .list-posts");
                    break;
                default:
                    page++;
                    active_page = page;
            }

            if (is_loading && active_page <= last_page && elem[0].scrollHeight + elem.scrollTop() > elem.height() - 200) {
                is_loading = false;
                fetchData(url+"?page=", active_page).done(function(response){
                    if((response.data).length > 0) {
                        for(var i = 0; i < (response.data).length; i++){
                            var file = false;
                            if(response.data[i].attachments) {
                                file = '{{route('module.self-service.feed-download')}}?path='+response.data[i].attachments[0].path;
                            }
                            $(".test-eff").fadeIn("slow");
                            placer.append(renderPosts((response.data)[i]));
                        }
                        switch (active_tab) {
                            case '#personalFeed':
                                lastPage_personal = response.last_page;
                                break;
                            case '#departmentFeed':
                                lastPage_department = response.last_page;
                                break;
                            default:
                                lastPage = response.last_page;
                        }
                        is_loading = true;
                    }
                });
            }
        }

        function fetchData(url, page){
            /**
             * url : http://hrms.local/feed/?page=
             * page : url?page=0
             *
             */

            return $.ajax({
                method: "GET",
                url: url + page,
                dataType: 'json',
                beforeSend: function () {
                    $("#loader").fadeIn();
                },
                success:function () {
                    $("#loader").fadeOut();
                }
            });
        }

        function renderPosts(post, hasfile = false){

            var hasfile_html = '';

            if(hasfile) {
                hasfile_html = '<a class="float-right" href="'+hasfile+'" download>File <i class="fa fa-download"></i></a>';
            }

            return '<div style="display:none" class="test-eff col-md-4">'+
                        '<div class="card card-customize  mb-5">'+
                            '<div class="card-header">'+
                                '<b class="card-title mb-2">'
                                    + post.title +
                                '</b>'+
                            '</div>'+
                            '<div class="card-body">'+
                                '<div class="content hideContent">'+
                                    '<div class="card-text">'
                                        + (post.body).replace(/<\/?[^>]+(>|$)/g, "").substring(0, 100) + hasfile_html +
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

        }
    </script>

@endsection
