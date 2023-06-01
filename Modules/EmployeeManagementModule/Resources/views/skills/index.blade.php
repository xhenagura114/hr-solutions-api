@extends('employeemanagementmodule::layouts.employees-management-extendable',['pageTitle' => 'Employee Management'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <script src="{{ asset("js/parsley.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="searchBar">
            <p class="mb-0">Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-lg-3 col-md-6">
                <input type="text" class="form-control hr-input" id="myInputTextField">
            </div>
            <div class="col-lg-3 col-md-6">
                <select class="selectpicker hr-input" data-live-search="true" id="filters">
                    @foreach($skills as $skill)
                        @if($skill->title != Null)
                    <option value="{{ $skill->id }}">{{ $skill->title }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="hr-content pt-3 pb-3">
            <div class="h-100 scroll">
                @if(Session::has('flash_message'))
                    <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                    </div>
                @endif

                <div class="container-fluid">

                    <div class="row mt-3 mb-2 pl-1">
                        <div class="col" id="loadTable">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{--Modal--}}
    <div id="editPartnersModal"
         class="modal fade" role="dialog">
        <div class="modal-dialog" style="max-width: 800px">
            <div class="modal-content">
                <div class="modal-body editPartnersModal editUserModal">
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        function get_skill(id) {
            $.ajax({
                method: "POST",
                url: '{{route("module.skills.search")}}',
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('.spinnerBackground').fadeOut(500);
                    $("#loadTable").html(response)
                }
            });
        }
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        $('#form').parsley();

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);

        $(window).bind("load", function () {

            get_skill($('#filters').val());

        });

        $('#filters').on('change', function () {

            get_skill($(this).val());

        });
    </script>
@endsection
