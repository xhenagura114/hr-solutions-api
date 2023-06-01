@if($currentUser->hasAnyAccess(["module.employee-history.restore", "module.employee-history.destroy"]))

    @extends('employeemanagementmodule::layouts.employees-management-extendable',['pageTitle' => 'Employee Management'])

@section('header-scripts')
    {{--add here additional header scripts--}}

    <script src="{{asset('js/isotope.pkgd.min.js')}}"></script>
    
    <script src="{{asset('js/horizontal.js')}}"></script>

@endsection

@section('content')
    <div class="container-fluid">
        <div class="searchBar">
            <p class="mb-0">Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <input type="text" class="form-control hr-input" id="myInputTextField">
            </div>
            @if(isset($company_enum))
                <div class="col-lg-3 col-md-6">
                    <select class="selectpicker hr-input" id="filter_company" data-live-search="true">
                        <option value="*">Company</option>
                        @foreach ($company_enum as $company)
                            <option value="{{$company}}">{{$company}}</option>
                        @endforeach
                        </select>
                    </div>
                @endif
        </div>
        <div class="hr-content pt-3 pb-3">
            <div class="h-100 scroll">
                <div class="w-100 filters">
                    <div class="btn-group btn-group-toggle filter-buttons" id="filters" data-toggle="buttons">
                        <label class="btn btn-light all active">
                            <input type="radio" name="options" id="all" autocomplete="off" data-filter="*" checked> All
                        </label>

                        @foreach ($departments as $department)
                            <label class="btn btn-light">
                                <input type="radio" name="options" id="optiondep-{{$department->departments->id}}"
                                       autocomplete="off" data-filter=".optiondep-{{$department->departments->id}}"
                                       checked> {{$department->departments->name}}
                            </label>
                        @endforeach

                    </div>
                </div>
                <div class="container-fluid">
                <div class="row mb-4 pl-1 mt-4">
                    <div class="col">
                        <b class="hr-default-text mb-4">Employee History</b>
                    </div>
                </div>
                <div class="row mt-3 mb-1 pl-1">
                    <div class="col">
                        <table class="table" id="table" >
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Quit Reason</th>
                                <th>Department</th>
                                <th>Company</th>
                                @if($currentUser->hasAnyAccess(["module.employee-history.restore", "module.employee-history.destroy"]))
                                    <th>Actions</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody id="applicants">
                            @foreach($users as $user)
                                <tr class="applicant optiondep-{{$user->department_id}} position-static">
                                    <td>{{$user->first_name}} {{$user->last_name}}</td>
                                    <td>{{ ($user->contract_start) ? date("d-m-Y", strtotime($user->contract_start)) : ''}}</td>
                                    <td>{{ ($user->contract_end) ? date("d-m-Y", strtotime($user->contract_end)) : ''}}</td>                                    <td>{{ $user->quit_reason }}</td>
                                    <td>{{$user->department_id ? $user->departments->name : ''}}</td>
                                    <td>{{$user->company ? $user->company : ''}}</td>
                                    @if($currentUser->hasAnyAccess(["module.employee-history.restore", "module.employee-history.destroy"]))
                                        <td>
                                            @if($currentUser->hasAccess([ "module.employee-history.destroy"]))
                                                <button class="btn btn-sm hr-outline pull-right deleteUser" type="button"
                                                        id="{{$user->id}}"><i class="fa fa-trash-o"></i></button>
                                            @endif

                                            @if($currentUser->hasAccess(["module.employee-history.restore"]))
                                                <button class="btn btn-sm hr-outline pull-right restoreUser"
                                                        style="margin-right: 3px;" id="{{$user->id}}"><i
                                                            class="fa fa-history"></i></button>
                                            @endif
                                        </td>
                                    @endif
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
    </script>
    <script>
          $(document).ready(function () {

            var oDataTable = $('#table').DataTable({
                "ordering": false,
                "pageLength": 15,
                responsive: true
            });
            

            $('#myInputTextField').keyup(function () {
                oDataTable.column(0).search($(this).val()).draw();
            })
            $("#filter_company").on("change", function() {
                var val = $(this).val();
                if(val == '*') {
                    oDataTable.column(5).search('').draw();
                }
                else {
                    oDataTable.column(5).search($(this).val()).draw();
                     }
                });
        });

        $grid = $('#applicants').isotope({
            itemSelector: '.applicant',
            layoutMode: 'horiz',
            transitionDuration: 0
        });

        $('#filters').on('click', '.btn', function () {
            var child = $(this).find('input');
            var filterValue = child.attr('data-filter');
            $grid.isotope({filter: filterValue});
        });

        $(".restoreUser").click(function () {
            var id = parseInt($(this).attr("id"));
            console.log(id);
            var rowElement = $(this).parent().parent();
            swal({
                title: 'Are you sure?',
                text: "Do you want to restore this employee",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then(function(result) {
                if(result.value)
            {
                $.ajax({
                    contentType: "application/json",
                    url: "{{ route("module.employee-history.restore") }}/" + id,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        "_method": 'PUT'
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
                            swal('Restored!', response.message, 'success')
                        } else if (response.status === 'error') {
                            swal('Error', response.message, 'warning')
                        }

                    }
                });
            }
        })
        });

        $(".deleteUser").click(function () {
            var id = parseInt($(this).attr("id"));
            var rowElement = $(this).parent().parent();
            swal({
                title: 'Are you sure?',
                text: "Do you want to permanently delete this item",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if(result.value)
            {
                $.ajax({
                    contentType: "application/json",
                    url: "{{ route("module.employee-history.destroy") }}/" + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        "_method": 'DELETE'
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
        })
        });
    </script>
@endsection
@endif
