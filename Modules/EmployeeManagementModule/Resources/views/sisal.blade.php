@extends('employeemanagementmodule::layouts.employees-management-extendable',['pageTitle' => 'Employee Management'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{asset('js/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <script src="{{ asset("js/parsley.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
@endsection

@section('content')
    <div class="container-fluid">
        @if($currentUser->hasAccess('module.employee.index'))
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
            <div class="searchBar">
                <p>{{ trans("label.search") }}</p>
            </div>

            <?php
            $oldVals = [isset($searchingVals) ? $searchingVals['first_name'] : '', isset($searchingVals) ? $searchingVals['status'] : ''];
            $selectEnum = $status_enum;
            $selectCompany = $company_enum;
            $items = ['First Name', 'Select Status'];
            ?>

            <div class="row align-items-end mb-5 searchForm">
                <div class="col-xl-2 col-lg-3 col-md-12">
                    <input value="{{isset($oldVals) ? $oldVals[0] : ''}}" type="text" class="form-control quicksearch hr-input" data-filter=".name"
                           name="first_name" id="first_name" placeholder="Name">
                </div>
                <div class="col-xl-2 col-lg-3 col-md-12 select">
                    <select class="filters-select selectpicker hr-input" id="filter_status">
                        <option value="">All Statuses</option>
                        @foreach($selectEnum as $status)
                            <option value="{{$status}}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-12 select">
                    <select class="filters-select-department selectpicker hr-input" id="filter_department" data-live-search="true">
                        <option value="">{{ trans("label.all") }}</option>
                        @foreach ($departments as $department)
                            <option value="optiondep-{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-12 select">
                    <select class="filters-select-company selectpicker hr-input" id="filter_company" data-live-search="true">
                        <option value="">Company</option>
                        @foreach ($company_enum as $company)
                            <option value="optiondep-{{$company}}">{{$company}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons"
                         data-sort-by="original-order" id="sorts">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" id="name" value="alphabet" autocomplete="off" data-sort-by="name" checked> A
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="contract_end" value="contract" autocomplete="off" data-sort-by="date"> <i class='fa fa-calendar'></i>
                        </label>
                    </div>
                </div>
                <div class="col text-right">
                    <button class="btn btn-sm btn-primary" onclick="cleanFilters()">{{ trans("label.clean_filters") }}</button>
                </div>
            </div>

            <div class="hr-content pt-3 pb-3 employee-list">
                <div class="employee-scroll">
                    <div class="row no-gutters ml-3">
                        <b class="hr-default-text mb-4">{{ trans("label.employees") }}</b>
                    </div>
                    <div class="row text-center">
                        <div class="col">
                            <div class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div class="row ml-4 employees" id="employeeResult">
                        @foreach ($users as $user)
                            <div data-priority="{{ $user->priority }}" class="col-lg-4 col-md-12 emp mb-5 min-height-100 optiondep-{{$user->department_id}} optiondep-{{$user->company}}">
                                <div class="row employee-card" style="border-color:{{$user->departments['color']}};">
                                    <div class="col-lg-5 col-md-12 text-center align-self-center">
                                        <img src="{{asset($user->photo_path)}}" class="rounded-img w-100" />
                                    </div>
                                    <div class="col align-self-center">
                                        <span class="name"> {{ $user->first_name  }} {{ $user->last_name  }}</span><br>
                                        <span>{{ isset($user->jobs->title) ? $user->jobs->title : '' }}</span><span
                                                class="date d-none"> {{ $user->contract_end  }}</span>
                                        <span class="d-none status">{{$user->status}}</span><br><br>

                                        @if($currentUser->hasAccess(['module.employee.edit', 'module.employee.update']))
                                            <button class="fa fa-edit default-color"
                                                    data-toggle="modal"
                                                    id={{$user->id}}
                                                            data-target="#editUserModal"
                                                    onclick="editUser({{ $user->id }});"></button>
                                        @endif

                                        @if($currentUser->hasAccess(['module.employee.destroy']))
                                            <button class="fa fa-trash-o default-color deleteUser"
                                                    id="{{$user->id}}_delete"></button>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row" id="no-users">
                        <div class="col">
                            <p class="text-center hr-default-text">{{ trans("label.no_user") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{--Modal--}}
    <div id="editUserModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body editUserModal">
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

            $grid = $('#employeeResult').isotope({
                itemSelector: '.emp',
                getSortData: {
                    name: '.name',
                    date: '.date',
                    priority: '[data-priority]'
                },
                sortBy: ['priority', 'name'],
                isAnimate: true
            });
        });
        $(".modal").on("hidden.bs.modal", function () {
            $(".modal-body").html("");
        });

        @if($currentUser->hasAccess(['module.employee.edit', 'module.employee.update']))
        function editUser(user_id) {
            var url = "{{ route("module.employee.edit") }}/" + user_id;
            $(".editUserModal").empty();
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $(".editUserModal").html(data);
                    $("#editUserModal").modal('show');
                }
            });
        }
        @endif

        var $grid;
        var qsRegex;

        function filter_data() {
            var search = $("#first_name").val(),
                filterValue = $("#filter_status").val(),
                filterDepartment = $("#filter_department").val(),
                filterCompany = $("#filter_company").val();

            $grid.isotope({
                filter:  function() {
                    var _this = $(this);
                    qsRegex = new RegExp(search, 'gi');
                    if( (filterValue == '' || _this.find('.status').text().match(filterValue)) && (search == '' ||  _this.find('.name').text().match(qsRegex)) && (filterDepartment == '' ||  _this.hasClass(filterDepartment)) && (filterCompany == '' ||  _this.hasClass(filterCompany)) ) {
                        return true;
                    }
                    return false;
                }
            });
        }

        $(function () {
            @if($currentUser->hasAccess(['module.employee.destroy']))

            $(document).on('click', '.deleteUser', function () {
                var id = parseInt($(this).attr("id"));
                var rowElement = $(this).parent().parent().parent();
                swal({
                    title: 'Do you want to delete this user?',
                    text: "Give the quit reason",
                    input: 'text',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    preConfirm: function (quit_reason) {
                        if(quit_reason == '') {
                            swal.showValidationError (
                                'Give the quit reason'
                            );
                            return false;
                        }
                    }
                }).then(function (result) {
                    if (result.value && result.value != '') {
                        $.ajax({
                            url: "{{ route("module.employee.destroy") }}/" + id,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            },
                            data: {
                                "quit_reason": result.value,
                            },
                            success: function (response) {
                                if (response.success) {
                                    rowElement.remove();
                                    $grid.isotope('reloadItems');
                                    $grid.isotope({
                                        itemSelector: '.emp',
                                        sortBy: 'name',
                                        isAnimate: true
                                    });
                                    swal('Deleted!', response.message, 'success')
                                } else if (response.status === 'error') {
                                    swal('Error', response.message, 'warning')
                                }

                            }
                        });
                    }
                });
            });
            @endif


            $('#sorts').on('click', '.btn', debounce( function () {
                var child = $(this).find('input');
                var sortByValue = child.attr('data-sort-by');
                $grid.isotope({sortBy: sortByValue});
            }, 200));

            function debounce( fn, threshold ) {
                var timeout;
                threshold = threshold || 100;
                return function debounced() {
                    clearTimeout( timeout );
                    var args = arguments;
                    var _this = this;
                    function delayed() {
                        fn.apply( _this, args );
                    }
                    timeout = setTimeout( delayed, threshold );
                };
            }

            $(".quicksearch").keyup( debounce( function() {
                filter_data();
            }, 200 ));
            $(".filters-select").on('change', filter_data);
            $(".filters-select-department").on("change", function() {
                filter_data();
                noResultsCheck();
            });
            $(".filters-select-company").on("change", function() {
                filter_data();
                noResultsCheck();
            });


            function noResultsCheck() {
                var iso = $grid.data('isotope');
                var count = iso.filteredItems.length;
                if (count === 0) {
                    $('#no-users').show();
                } else {
                    $('#no-users').hide();
                }
            }

            $('#no-users').hide();
            $('.lds-ripple').hide();
        });


        @if($currentUser->hasAccess('module.employee.index'))

        function cleanFilters() {
            $('#first_name').val('');
            $(".selectpicker").val('');
            $(".selectpicker").selectpicker('refresh');

            $grid.isotope({
                itemSelector: '.emp',
                getSortData: {
                    name: '.name',
                    date: '.date'
                },
                filter: '*',
                sortBy: 'name',
                isAnimate: true
            });
        }
        @endif

    </script>
@endsection
