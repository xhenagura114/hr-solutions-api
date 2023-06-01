@if($currentUser->hasAccess(["module.requests.history"]))
    @extends('selfservicemodule::layouts.requests-extendable',['pageTitle' => 'Self-Service'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
@endsection


@section('content')

    <div class="container-fluid">
        <div class="searchBar">
            <p>Search</p>
        </div>
        <div class="row align-items-end mb-5">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <input type="text" class="form-control hr-input" id="myInputTextField" placeholder="Name">
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4">
                <select class="filters-select-company selectpicker hr-input" id="filter_company"
                        data-live-search="true">
                    <option value="">Company</option>
                    @foreach ($company_enum as $company)
                        <option value="{{$company}}">{{$company}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="hr-content pt-4 pb-4 full-wrapper">

            <div class="h-100 scroll">

                <div class="container-fluid">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('flash_message'))
                        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="hr-default-text mb-4">Approved Requests</h5>
                            <hr>
                        </div>
                        <div class="col-md-12">

                            <div class="table-responsive" id="loadTable"></div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

    <div class="modal" id="editRequest" tabindex="-1" role="dialog"
         aria-labelledby="editRequestTitle" aria-hidden="true">
    </div>
@stop


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script>

        $(window).bind("load", function () {

            $.ajax({
                method: "GET",
                url : '{{route("module.requests.history-table-load")}}',
                success : function (response) {
                    $('.spinnerBackground').fadeOut(500);

                    $("#loadTable").html(response)
                }
            });

        });

        @if($currentUser->hasAccess(["module.requests.history-edit"]))
        function editHoliday(id) {
            $('#editRequest').modal('show');
            var request = $.ajax({
                url: "{{route('module.requests.history-edit')}}/" + id,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: "html"
            });

            request.done(function (data) {
                $('#editRequest').html(data);
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        }
        @endif

        @if($currentUser->hasAccess(["module.requests.delete-request"]))
        function deleteRequest(id) {
            var request = $.ajax({
                url: "{{route('module.requests.delete-request')}}/" + id,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: "json"
            });

            request.done(function (data) {
                swal({
                    type: 'success',
                    title: 'Your Request has been deleted!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('tbody.pendingRequest').find('#' + id).remove();
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        }
        @endif
    </script>
@endsection
@endif
