@if($currentUser->hasAccess("module.calendar.home"))
    @extends('calendarmodule::layouts.calendar-extendable',['pageTitle' => 'Calendar'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
@endsection

@section('header-scripts')

    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <script src="{{ asset("js/parsley.min.js") }}"></script>
    {{--add here additional header scripts--}}
    <link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
    <link rel="stylesheet" href="{{asset("css/evol-colorpicker.min.css")}}">
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">

@endsection

@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-4 pb-4 full-wrapper calendarView">

            <div class="container-fluid">

                @if(Session::has('flash_message'))
                    <div class="container">
                        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                        </div>
                    </div>
                @endif

                <div class="row calendarHeight">
                    <div class="col-sm-12 col-md-8">
                        <div class="calendarStyles">
                            <h1 class="departments-title">Calendar</h1>
                            <div id='calendar'></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 legendStyle">
                        <h1 class="legend-title">Legend of events</h1>
                        <ul class="event-list">
                            @foreach($event_types as $event_type)
                                <li id="{{$event_type->id}}">
                                    <div class="row">
                                        @if($currentUser->hasAccess("module.calendar.delete-type"))
                                            <div class="col-md-1 col-sm-1 event-type-delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </div>
                                        @endif

                                        @if($currentUser->hasAccess("module.calendar.edit-type"))
                                            <div class="col-md-1 col-sm-1" id="event-type-edit">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </div>
                                        @endif

                                        <div class="col-md-9 col-sm-9 event-type-edit">
                                            <div class="eventType">
                                            <span class="color-type"
                                                  style="background-color: {{$event_type->color}}"
                                                  value="{{$event_type->color}}"></span>
                                                <span class="name-type">{{$event_type->type}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if($currentUser->hasAccess("module.calendar.create-type"))
                            <div class="add-new-type">
                        <span class="color-picker">
                            <input type="text" class="colorPicker" name="colorPicker" id="colorPicker" value="#2799fa">
                        </span>
                                <span class="event-type-name">
                            <input type="text" name="eventType" id="event-type" placeholder="Create event type">
                        </span>
                                <span class="add-type">
                            <button id="add-type-button"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
                        </span>
                                <script>
                                    $(document).ready(function () {
                                        $("#colorPicker").colorpicker();
                                    });
                                </script>
                            </div>
                        @endif
                    </div>
                </div>

                <form role="form" id="form" method="POST" action="{{ route('module.calendar.create-event') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="container-fluid create-emp">
                        <div class="tab-content">
                            <div class="form-group row ml-3 mr-3">
                                <div class="col-9">
                                    <div class="row mt-5">
                                        <div class="col-lg-4 col-xl-3 col-md-12">
                                            <label class="hr-default-text">Event Name</label>
                                            <input type="text" class="form-control required info-required"
                                                   name="title" id="title" required="" autofocus>
                                        </div>
                                        <div class="col-lg-4 col-xl-3 col-md-12 ">
                                            <label class="hr-default-text">Event Start Date</label>
                                            <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                <input type="text" class="form-control" placeholder="Choose date"
                                                       id="time" name="start_date">
                                                <div class="input-group-addon calendar-icon">
                                                    <span class="fa fa-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-xl-3 col-md-12 ">
                                            <label class="hr-default-text">Event End Date</label>
                                            <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                <input type="text" class="form-control" placeholder="Choose date"
                                                       id="time" name="end_date">
                                                <div class="input-group-addon calendar-icon">
                                                    <span class="fa fa-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-lg-4 col-xl-3 col-md-12">
                                            <label class="hr-default-text">Event Category</label>
                                            <select id="event_type_id" name="event_type_id" class="selectpicker" multiple
                                                    title="Choose one of the following..." data-live-search="true" data-parsley-multiple="event_type_id">
                                                @foreach ($event_types as $skill)
                                                    <option value="{{$skill->id}}">{{$skill->type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-xl-3 col-md-12">
                                            <label class="hr-default-text"> Upload CV</label>
                                            <div class="upload-file">
                                                <input name="cv_path" id="cv_path" type="file"
                                                       class="input-file info-required required"
                                                       accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf"
                                                       data-parsley-group="first">
                                                <label for="cv_path" class="light-hr-input cv_label">
                                                    <span>Upload a file</span>
                                                    <strong class="pull-right"> <i
                                                                class="fa fa-upload"></i></strong>
                                                </label>
                                                <div id="file-upload-filename"></div>
                                            </div>
                                            <input type="hidden" name="docs[category_name]" value="CV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-4">
                            <button type="submit" class="btn btn-sm btn-success" id="save-btn"> {{ trans('label.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });
    </script>

    {{--add here additional footer scripts--}}
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
    <script src="{{asset("js/evol-colorpicker.min.js")}}"></script>

    <script>


        var input = document.getElementById( 'cv_path' );
        var infoArea = document.getElementById( 'file-upload-filename' );

        input.addEventListener( 'change', showFileName );

        function showFileName( event ) {

            // the change event gives us the input it occurred in
            var input = event.srcElement;
            var fileName = input.files[0].name;

            infoArea.textContent = 'File name: ' + fileName;
        }

        $('.addSkill').on('keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                var template = '<span class="mr-1">\n' +
                    '<span class="badge"></span>\n' +
                    ' <input type="hidden" name="user[event_types][]">' +
                    '</span>';
                var skillInput = $('.addSkill').val();
                if (skillInput === '') {
                    return;
                }
                $('.event_types').append(template);
                var lastSpan = $('.event_types').find('span:last')[0];
                var lastInput = $('.event_types').find('input:last')[0];
                $(lastInput).val(skillInput);
                $(lastSpan).html(skillInput + '<i class="fa fa-times" onclick="removeTag($(this).parent().parent())"></i>');
                $('.addSkill').val('');
            }
        });
        $(document).ready(function () {

            /*Generate Script*/
            function generateScript() {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.text = '$(document).ready(function () {\n' +
                    '            $("#colorPicker_edit").colorpicker();\n' +
                    '          });';
                $('.edit-new-type').append(script);

            }


            //will decide later whether these changes will be deleted or not

            /*Generate modal*/
            {{--function genMod() {--}}
            {{--    return $.ajax({--}}
            {{--        url: "{{route('module.calendar.event-modal')}}",--}}
            {{--        method: "POST",--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': '{{csrf_token()}}'--}}
            {{--        },--}}
            {{--        enctype: 'multipart/form-data',--}}
            {{--        data: {},--}}
            {{--        processData: false,--}}
            {{--        dataType: "html",--}}
            {{--        contentType: false,--}}
            {{--    });--}}
            {{--}--}}

            /*Calendar*/
            $('#calendar').fullCalendar({
                header: {
                    left: '',
                    center: '',
                    right: 'today, month, agendaWeek, prev, next, title'
                },
                height: 'parent',
                eventDurationEditable: false,
                defaultDate: '{!! \Carbon\Carbon::now() !!}',
                navLinks: true,
                selectable: true,
                unselectAuto: true,
                selectHelper: true,

                //will decide later whether these changes will be deleted or not

                {{--select: function (start, end, event) {--}}
                {{--    @if($currentUser->hasAccess("module.calendar.create-event"))--}}
                {{--    genMod().done(function (data) {--}}
                {{--        swal({--}}
                {{--            title: 'Add event',--}}
                {{--            type: 'info',--}}
                {{--            html: data,--}}
                {{--            showCloseButton: true,--}}
                {{--            showCancelButton: true,--}}
                {{--            focusConfirm: false,--}}
                {{--            confirmButtonText:--}}
                {{--                '<i class="fa fa-floppy-o"></i>&nbsp; Add',--}}
                {{--            confirmButtonAriaLabel: 'Thumbs up, great!',--}}
                {{--            cancelButtonText:--}}
                {{--                '<i class="fa fa-ban"></i>&nbsp; Cancel',--}}
                {{--            cancelButtonAriaLabel: 'Thumbs down',--}}
                {{--        }).then(function (result) {--}}
                {{--            if (result.value) {--}}
                {{--                var eventData;--}}
                {{--                var title = $('#eventModal #title').val();--}}
                {{--                var cv_path = $('#eventModal #cv_path').val().replace(/^.*[\\\/]/, '');--}}
                {{--                var category = $('#eventModal #categoryEvent').val();--}}
                {{--                var eventTypeId = $('#eventModal #categoryEvent').children(':selected').attr('id');--}}
                {{--               // console.log(cv_path);--}}

                {{--                if (title) {--}}
                {{--                    /*Post Event*/--}}
                {{--                    var request = $.ajax({--}}
                {{--                        url: "{{route('module.calendar.create-event')}}",--}}
                {{--                        method: "POST",--}}
                {{--                        headers: {--}}
                {{--                            'X-CSRF-TOKEN': '{{csrf_token()}}'--}}
                {{--                        },--}}
                {{--                        // contentType: 'multipart/form-data',--}}
                {{--                        data: {--}}
                {{--                            title: title,--}}
                {{--                            color: category,--}}
                {{--                            cv_path: cv_path,--}}
                {{--                            start_date: start.format(),--}}
                {{--                            end_date: end.format(),--}}
                {{--                            event_type_id: eventTypeId--}}
                {{--                        },--}}
                {{--                        dataType: "json"--}}
                {{--                    });--}}

                {{--                    request.done(function (data) {--}}
                {{--                        eventData = {--}}
                {{--                            id: data.id,--}}
                {{--                            title: moment(start).format('HH:mm')+' '+title,--}}
                {{--                            start: start,--}}
                {{--                            end: end,--}}
                {{--                            color: category--}}
                {{--                        };--}}
                {{--                        $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true--}}
                {{--                        swal({--}}
                {{--                            type: 'success',--}}
                {{--                            title: 'Your event has been created',--}}
                {{--                            showConfirmButton: false,--}}
                {{--                            timer: 1000--}}
                {{--                        });--}}
                {{--                    });--}}

                {{--                    request.fail(function (jqXHR, textStatus) {--}}
                {{--                        alert("Request failed: " + textStatus);--}}
                {{--                    });--}}
                {{--                }--}}
                {{--            }--}}
                {{--            else if (result.dismiss === swal.DismissReason.cancel) {--}}
                {{--                swal({--}}
                {{--                    type: 'error',--}}
                {{--                    title: 'Cancelled!',--}}
                {{--                    text: 'You cancelled event!',--}}
                {{--                    showConfirmButton: false,--}}
                {{--                    timer: 1000--}}

                {{--                });--}}
                {{--            }--}}
                {{--        });--}}
                {{--    });--}}

                {{--    $('#calendar').fullCalendar('unselect');--}}
                {{--    @endif--}}

                {{--},--}}
                @if($currentUser->hasAccess("module.calendar.delete-event"))
                eventRender: function (event, element) {
                    if (event.end != null || event.delete) {
                        element.html(event.title + "<i  class='fa fa-close pull-right text-danger remove-event' id='" + event.id + "'></i>");
                    }

                    element.find(".remove-event").click(function () {
                        var request = $.ajax({
                            url: "{{route('module.calendar.delete-event')}}",
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            data: {
                                id: event.id
                            },
                            dataType: "json"
                        });

                        request.done(function (data) {
                            swal({
                                type: 'success',
                                title: 'Your event has been deleted',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        });

                        request.fail(function (jqXHR, textStatus) {
                            alert("Request failed: " + textStatus);
                        });
                        $('#calendar').fullCalendar('removeEvents', event._id);
                    });
                },
                @endif
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                eventBackgroundColor: '#2799fa',
                eventBorderColor: '#2799fa',
                eventTextColor: '#fff',
                events: {!! json_encode($all_events) !!}
            });

            @if($currentUser->hasAccess("module.calendar.create-type"))
            /*Add event type*/
            $(document).on('click', '#add-type-button', function () {
                var type = $('#event-type').val();
                var colorType = $('#colorPicker').val();

                /*Add event type*/
                var request = $.ajax({
                    url: "{{route('module.calendar.create-type')}}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    data: {
                        type: type,
                        color: colorType
                    },
                    dataType: "json"
                });

                request.done(function (data) {

                    if (data.status == "success") {
                        swal({
                            type: 'success',
                            title: 'Your event type has been created',
                            showConfirmButton: false,
                            timer: 1000
                        });

                        /*Append new type*/
                        $('.event-list').append('<li id="' + data.created_event_type.id + '">\n' +
                            '                      <div class="row">\n' +
                            '                        <div class="col-md-1 col-sm-1 event-type-delete">\n' +
                            '                           <i class="fa fa-trash" aria-hidden="true"></i>\n' +
                            '                        </div>' +
                            '                        <div class="col-md-1 col-sm-1" id="event-type-edit">\n' +
                            '                           <i class="fa fa-pencil-square-o" aria-hidden="true"></i>\n' +
                            '                        </div>' +
                            '                        <div class="col-md-9 col-sm-9 event-type-edit">\n' +
                            '                           <div class="eventType">\n' +
                            '                              <span class="color-type" style="background-color: ' + data.created_event_type.color + '" value="' + data.created_event_type.color + '"></span>\n' +
                            '                              <span class="name-type">' + data.created_event_type.type + '</span>\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                       </div>\n' +
                            '                     </li>');


                        /*Clear input*/
                        $('#event-type').val('');
                    }
                    else {
                        swal({
                            type: 'error',
                            title: 'Your event type has not been created',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }

                });
                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });
            @endif

            @if($currentUser->hasAccess("module.calendar.edit-type"))
            /*Edit event type*/
            $(document).on('click', '.event-list li #event-type-edit', function () {
                var currentType = $(this).closest('li');
                var id = currentType.attr('id');
                var edit_new_type;
                var eventType;
                var color;
                var color_new;

                swal({
                    title: 'Edit event type',
                    type: 'info',
                    html:
                        '<div id="eventTypeModal">' +
                        '  <div class="edit-new-type">\n' +
                        '   <span class="color-picker">\n' +
                        '     <input type="text" class="colorPicker" name="colorPicker" id="colorPicker_edit">\n' +
                        '   </span>\n' +
                        '   <span class="event-type-name">\n' +
                        '      <input type="text" name="eventType" id="event-type" placeholder="Edit event type">\n' +
                        '    </span>' +
                        '  </div>' +
                        '</div>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:
                        '<i class="fa fa-floppy-o"></i>&nbsp; Update',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText:
                        '<i class="fa fa-ban"></i>&nbsp; Cancel',
                    cancelButtonAriaLabel: 'Thumbs down',
                }).then(function (result) {
                    if (result.value) {
                        eventType = edit_new_type.find('#event-type').val();
                        color_new = edit_new_type.find('#colorPicker_edit').val();
                        if (color_new == '') {
                            color_new = color;
                        }
                        var request = $.ajax({
                            url: "{{route('module.calendar.edit-type')}}",
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            data: {
                                id: id,
                                type: eventType,
                                color: color_new
                            },
                            dataType: "json"
                        });

                        request.done(function (data) {

                            $('#calendar').fullCalendar('removeEvents');
                            $('#calendar').fullCalendar('addEventSource', data.all_events);

                            $("#categoryEvent option").each(function (i) {
                                if ($(this).attr('id') == id) {
                                    $(this).attr('id', id).val(color_new).text(eventType);
                                }
                            });
                            currentType.find('.name-type').text(eventType);
                            currentType.find('.color-type').attr('value', color_new).css('background-color', color_new);

                            swal({
                                type: 'success',
                                title: 'Success!',
                                text: 'Your event type has been edited.',
                                showConfirmButton: false,
                                timer: 1000

                            });
                            currentType = null;

                        });

                        request.fail(function (jqXHR, textStatus) {
                            alert("Request failed: " + textStatus);
                        });
                    }
                    else if (result.dismiss === swal.DismissReason.cancel) {
                        swal({
                            type: 'error',
                            title: 'Cancelled!',
                            text: 'Your event type file is safe :)',
                            showConfirmButton: false,
                            timer: 1000

                        });

                    }
                });
                if ($(".swal2-container").length > 0) {
                    generateScript();
                    setTimeout(function () {
                        edit_new_type = $('.edit-new-type');
                        eventType = currentType.find('.name-type').text();
                        color = currentType.find('.color-type').attr('value');

                        edit_new_type.find('#event-type').val(eventType);
                        edit_new_type.find('.evo-pointer').css('background-color', color);

                    }, 100);
                }
            });
            @endif

            @if($currentUser->hasAccess("module.calendar.delete-type"))
            /*Delete event type*/
            $(document).on('click', '.event-list li .event-type-delete', function () {
                var currentType = $(this).closest('li');
                var id = currentType.attr('id');

                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then(function (result) {
                    if (result.value) {

                        var request = $.ajax({
                            url: "{{route('module.calendar.delete-type')}}",
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            data: {
                                id: id
                            },
                            dataType: "json"
                        });

                        request.done(function (data) {
                            swal({
                                type: 'success',
                                title: 'Deleted!',
                                text: 'Your event type has been deleted.',
                                showConfirmButton: false,
                                timer: 1000

                            });
                            $('#calendar').fullCalendar('removeEvents');
                            $('#calendar').fullCalendar('addEventSource', data.all_events);
                            currentType.remove();
                            currentType = null;
                        });

                        request.fail(function (jqXHR, textStatus) {
                            alert("Request failed: " + textStatus);
                        });

                    }
                    else if (result.dismiss === swal.DismissReason.cancel) {
                        swal({
                            type: 'error',
                            title: 'Cancelled!',
                            text: 'Your event type file is safe :)',
                            showConfirmButton: false,
                            timer: 1000

                        });
                    }
                });

            });
            @endif

        });

        $("#cv_path").change(function () {
            readURL(this);
        });

    </script>
@endsection
@endif
