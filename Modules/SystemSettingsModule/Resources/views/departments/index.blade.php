@extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('header-scripts')
    <link rel="stylesheet" href="{{asset("css/evol-colorpicker.min.css")}}">
@endsection


@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-5 pb-5 full-wrapper">

            <div class="container-fluid">

                @if(Session::has('flash_message'))
                    <div class="container">
                        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                        </div>
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


                <h1 class="departments-title">Departments</h1>

                <div class="row department-buttons">
                    <div class="col-md-8 col-sm-12">
                        <div class="row">

                            @if($currentUser->hasAccess("module.departments.new-department"))
                                <div class="col-md-4 col-sm-12 create-root">
                                    <button>Create Heighest level</button>
                                </div>
                            @endif

                            @if($currentUser->hasAccess("module.departments.edit-department"))
                                <div class="col-md-4 col-sm-12 rename-selected">
                                    <button>Rename</button>
                                </div>
                            @endif

                            @if($currentUser->hasAccess("module.departments.delete-department"))
                                <div class="col-md-4 col-sm-12 delete-selected">
                                    <button>Delete</button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row department-tree">
                    <div class="col-md-7 col-sm-12">
                        <ul class="root">
                            @foreach($departments as $department)
                                @if($department->parent_id == null)
                                    <li id="{{$department->id}}">
                                        <div class="department">
                                            @if($currentUser->hasAccess("module.departments.department-color"))
                                                <span class="color-picker"
                                                      style="background-color: {{$department->color}}">
                                                <input type="text" class="colorPicker"
                                                       name="colorPicker"
                                                       id="colorPicker_{{$department->id}}">

                                                <label for="colorPicker"><i
                                                            class="fa fa-eyedropper"
                                                            aria-hidden="true"></i></label>
                                                <script>
                                                    /*Color Picker*/
                                                    $(document).ready(function () {
                                                        $("#colorPicker_{{$department->id}}").colorpicker();
                                                    });
                                                </script>
                                            </span>
                                            @endif

                                            <span class="expand-view"><i
                                                        class="fa fa-circle"
                                                        aria-hidden="true"></i></span>
                                            <span class="department-name"
                                                  style="color: {{$department->color}}">{{$department->name}}</span>
                                            @if($currentUser->hasAccess("module.departments.new-department"))
                                                <span class="add-new-department">Add</span>
                                            @endif
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                </div>

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
    <script src="{{asset("js/evol-colorpicker.min.js")}}"></script>
    <script>

        var click = 0;
        var defaultText = '';

        /*Generate Script*/
        function generateScript(id) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.text = '$(document).ready(function () {' +
                '            $("#colorPicker_' + id + '").colorpicker();' +
                '          });';
            $('.picker_' + id).append(script);

        }

        /*Tree Node*/
        function treeNode(id, parent_id, name, color) {

            $('#' + parent_id).append('<ul class="has-children ' + ((parent_id == 1) ? 'open' : '') + '">' +
                '                                           <li id="' + id + '">' +
                '                                            <div class="department-sub-field">' +
                    @if($currentUser->hasAccess("module.departments.department-color"))

                        '                                              <span class="color-picker picker_' + id + '" style="background-color: ' + color + '">' +
                '                                                           <input type="text" class="colorPicker" name="colorPicker" id="colorPicker_' + id + '">' +
                '                                                           <label for="colorPicker"><i class="fa fa-eyedropper" aria-hidden="true"></i></label>' +
                '                                                       </span>' +
                    @endif
                        '                                                <span class="expand-view"><i class="fa fa-circle"\n' +
                '                                                                             aria-hidden="true"></i></span>' +
                '                                                <span class="department-name" style="color: ' + color + '" >' + name + '</span>' +
                    @if($currentUser->hasAccess("module.departments.new-department"))
                        '                                                <span class="add-new-department">Add</i></span>' +
                    @endif
                        '                                            </div>\n' +
                '                                        </li>' +
                '                               </ul>'
            );
            generateScript(id);

        }

        /*Root Node*/
        function rootNode(id, parent_id, name, color) {
            $('.root').append('<li id="' + id + '">\n' +
                '                 <div class="department">\n' +
                    @if($currentUser->hasAccess("module.departments.department-color"))

                        '                   <span class="color-picker picker_' + id + '" style="background-color: ' + color + '">' +
                '                     <input type="text" class="colorPicker" name="colorPicker" id="colorPicker_' + id + '">' +
                '                     <label for="colorPicker"><i class="fa fa-eyedropper" aria-hidden="true"></i></label>' +
                '                   </span>' +
                    @endif
                        '                   <span class="expand-view"><i class="fa fa-circle" aria-hidden="true"></i></span>\n' +
                '                   <span class="department-name" style="color: ' + color + '">' + name + '</span>\n' +
                    @if($currentUser->hasAccess("module.departments.new-department"))

                        '                   <span class="add-new-department">Add</i></span>\n' +
                    @endif
                        '                 </div>\n' +
                '               </li>');
            generateScript(id);
        }

        /*Tree Render*/
        $(document).ready(function () {
            var departments = JSON.parse('{!! json_encode($departments) !!}');

            $.each(departments, function (index, value) {

                if (value.parent_id != null) {
                    treeNode(value.id, value.parent_id, value.name, value.color);
                }
            });

            $(".department-tree li").each(function (index) {
                if ($(this).children('ul').length == 0) {
                    $(this).addClass('no-children');
                }
            });

        });

        /*Expand View*/
        $(document).on('click', '.expand-view', function () {
            // var expandView = $(this);
            // if ($(this).find('i').hasClass('fa-plus') && $(this).closest('li').find('ul').hasClass('has-children')) {
            //     $(this).find('i').removeClass('fa-plus');
            //     $(this).find('i').addClass('fa-minus');
            // } else {
            //     $(this).find('i').removeClass('fa-minus');
            //     $(this).find('i').addClass('fa-plus');
            // }
            $(this).parent().parent().children('.has-children').toggleClass('open');
        });

        /*Append Form Child*/
        $(document).on('click', '.add-new-department', function () {
            var current = $(this).parent();
            if (click == 0) {
                $('<li class = "addDepartment" >\n' +
                    '<div class= "department-sub-field" >\n' +
                    '<input type="text" name="departmentName" id="departmentName" placeholder="Enter Department Name">' +
                    '<button type = "button" name = "departmentSubmit" id = "departmentSubmit" value = "Add" ><i class = "fa fa-plus" aria-hidden = "true" ></i></button>' +
                    '<button type = "button" name = "departmentCancel" id = "departmentCancel" value = "Cancel" ><i class="fa fa-trash-o" aria-hidden = "true" ></i></button>' +
                    '</div>\n' +
                    '</li>').insertAfter(current);
                click = 1;
            }
        });

        @if($currentUser->hasAccess("module.departments.new-department"))
        /*Post Department*/
        $(document).on('click', '#departmentSubmit', function () {

            /*Variables*/
            var parent_id = $(this).parent().parent().parent().attr('id');
            var departmentName = $(this).parent().find('#departmentName').val();

            if (parent_id == undefined) {
                parent_id = null;
            }

            /*Start Ajax*/
            var request = $.ajax({
                url: "{{route('module.departments.new-department')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: {
                    parent_id: parent_id,
                    name: departmentName,
                    color: '#2799fa'
                },
                dataType: "json"
            });

            request.done(function (data) {
                if (parent_id == null) {
                    rootNode(data.id, parent_id, departmentName, data.color)
                } else {
                    treeNode(data.id, parent_id, departmentName, data.color);
                }
                $('.addDepartment').remove();
                // var expand = $('#' + parent_id + ' .expand-view');
                // if (expand.find('i').hasClass('fa-plus')) {
                //     expand.find('i').removeClass('fa-plus');
                //     expand.find('i').addClass('fa-minus');
                // } else {
                //     expand.find('i').removeClass('fa-minus');
                //     expand.find('i').addClass('fa-plus');
                // }
                // $('#' + parent_id).find('.has-children').addClass('open');
                // $('#' + parent_id).removeClass('no-children');
                // $('#' + data.id).addClass('no-children');
                click = 0;
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
                click = 0;
            });
        });
        @endif

        /*Cancel Department*/
        $(document).on('click', '#departmentCancel', function () {
            $('.addDepartment').remove();
            click = 0;
        });

        @if($currentUser->hasAccess("module.departments.department-color"))
        /*Color Picker*/
        $(document).on('change', '.colorPicker', function () {

            /*Variables*/
            var color = $(this).val();
            var id = $(this).closest('li').attr('id');

            /*Start Ajax*/
            var request = $.ajax({
                url: "{{route('module.departments.department-color')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: {
                    color: color,
                    id: id
                },
                dataType: "json"
            });

            request.done(function (data) {
                swal({
                    type: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000
                });
                $('#' + id + ' .color-picker').css('background-color', color);
                $('#' + id + ' .department-name').css('color', color);
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });


        });
        @endif

        /*Add Selected Department*/
        $(document).on('click', '.root li .department-name', function () {
            if ($('.root li').find('div').hasClass('dep-selected')) {
                var current = $('.root li .dep-selected');
                $('.root li').find('div').removeClass('dep-selected');
                var dep = current.find('.department-name');
                dep.text(defaultText);
                $(this).closest('div').removeClass('dep-selected');
                dep.attr('contenteditable', 'false');
                $('.approve').remove();
                $('.cancel').remove();
                click = 0;
            }
            defaultText = $(this).text();
            $(this).closest('div').addClass('dep-selected');
        });

        /*Add new root departments*/
        $(document).on('click', '.create-root button', function () {
            var current = $(this).parent();
            if (click == 0) {
                $('.root').append('<li class = "addDepartment rootDepartment" >\n' +
                    '<div class = "department-sub-field" >\n' +
                    '<input type="text" name="departmentName" id="departmentName" placeholder="Enter Department Name">' +
                    '<button type = "button" name = "departmentSubmit" id = "departmentSubmit" value = "Add" ><i class = "fa fa-plus" aria-hidden = "true" ></i></button>' +
                    '<button type = "button" name = "departmentCancel" id = "departmentCancel" value = "Cancel" ><i class = "fa fa-trash-o" aria-hidden = "true" ></i></button>' +
                    '</div>\n' +
                    '</li>');

                click = 1;
            }
            $('.department-sub-field').find('#departmentName').focus();
        });

        /*Rename Selected*/
        $(document).on('click', '.rename-selected button', function () {
            if (click == 0) {
                var current = $('.root li .dep-selected');
                var dep = current.find('.department-name');
                dep.attr('contenteditable', 'true').focus();
                current.append('<span class="approve"><i class="fa fa-check" aria-hidden="true"></i></span>');
                current.append('<span class="cancel"><i class="fa fa-times" aria-hidden="true"></i></span>');
                click = 1;
            }
        });

        @if($currentUser->hasAccess("module.departments.edit-department"))
        /*Post Department after rename*/
        $(document).on('click', '.root li .dep-selected .approve', function () {
            var text = $(this).parent().find('.department-name').text();
            var id = $(this).closest('li').attr('id');
            var current = $('.root li .dep-selected');
            var dep = current.find('.department-name');

            /*Start Ajax*/
            var request = $.ajax({
                url: "{{route('module.departments.edit-department')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: {
                    id: id,
                    name: text
                },
                dataType: "json"
            });

            request.done(function (data) {
                swal({
                    type: 'success',
                    title: 'Your department has been edited',
                    showConfirmButton: false,
                    timer: 1000
                });
                click = 0;
                $(this).closest('div').removeClass('dep-selected');
                dep.attr('contenteditable', 'false');
                $('.approve').remove();
                $('.cancel').remove();
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
                click = 0;
            });
        });
        @endif

        /*Cancel Department Edit*/
        $(document).on('click', '.root li .dep-selected .cancel', function () {
            var current = $('.root li .dep-selected');
            var dep = current.find('.department-name');
            dep.text(defaultText);
            $(this).closest('div').removeClass('dep-selected');
            dep.attr('contenteditable', 'false');
            $('.approve').remove();
            $('.cancel').remove();
            click = 0;
        });

        @if($currentUser->hasAccess("module.departments.delete-department"))
        /*Delete Selected*/
        $(document).on('click', '.delete-selected button', function () {
            var current = $('.root li .dep-selected');
            var id = current.closest('li').attr('id');
            var parent_id = current.closest('ul').closest('li').attr('id');

            if (current.length == 0) {
                swal({
                    type: 'error',
                    title: 'Please select one department',
                    showConfirmButton: true
                });
            } else {
                /*Start Ajax*/
                var request = $.ajax({
                    url: "{{route('module.departments.delete-department')}}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    data: {
                        id: id,
                    },
                    dataType: "json"
                });

                request.done(function (data) {
                    swal({
                        type: 'success',
                        title: 'Your department has been deleted',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    $('li#' + id).closest('.has-children').remove();
                    $('#' + parent_id).addClass('no-children');
                    $('li#' + id).remove();
                });

                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                    click = 0;
                });
            }

        });
        @endif

    </script>

    <script>

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

    </script>

@endsection