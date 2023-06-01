@extends('reportsmodule::layouts.master', ['pageTitle' => 'Reports'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection

@section('content')
    <!-- <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

    <div class="container-fluid reports-page">
        <div class="hr-content pt-4 pb-4">

            <div class="h-100 pl-4 pr-4 scroll">
                <div class="ml-3 mt-4 mb-5">
                    <b class="hr-default-text d-block">Reports</b>
                </div>
                <div class="row align-items-end mb-5">

                    @if(isset($departments))
                       <div class="col-lg-3 col-md-6">
                             <select class="selectpicker hr-input" id="filter_department" data-live-search="true">
                                   <option value="*">Department</option>
                                    @foreach ($departments as $dep)
                                       @if($dep)
                                           <option value="{{$dep->name}}">{{$dep->name}}</option>
                                       @endif
                                    @endforeach
                             </select>
                       </div>
                    @endif
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
                    @if(isset($companies))
                        <div class="col-lg-3 col-md-6">
                            <select class="selectpicker hr-input" id="companies" data-live-search="true">
                                <option value="*">Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{$company}}">{{$company}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if(isset($gender_enum))
                        <div class="col-lg-3 col-md-6">
                            <select class="selectpicker hr-input" id="filter_gender" data-live-search="true">
                                <option value="*">Gender</option>
                                @foreach ($gender_enum as $gender)
                                    <option value="{{$gender}}">{{$gender}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if(isset($contract_start_year))
                        <div class="col-lg-3 col-md-6">
                               <select class="selectpicker hr-input" id="contract_start" data-live-search="true">
                                    <option value="*">Contract Start Year</option>
                                    @foreach ($contract_start_year as $year)
                                       <option value="{{$year}}">{{$year}}</option>
                                    @endforeach
                               </select>
                               </div>
                    @endif
                </div>
                {!! $dataTable->table(['class' => 'text-center', 'id'=> 'tableReport']) !!}
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

    <script src="/vendor/datatables/buttons.server-side.js"></script>

    {!! $dataTable->scripts() !!}
@endsection

@section('footer-scripts')
    <script>

        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);


    </script>
    <script>
        var links = [];
        $(document).ready(function () {


            var table = $('#tableReport').DataTable();
            table.on('order.dt search.dt', function() {
                var rows = 1;
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = rows++;
                });
            }).draw();

            $('#myInputTextField').keyup(function () {
                table.search($(this).val()).draw();
            });

            $("#filter_department").on("change", function() {
               var val = $(this).val();
               if(val == '*') {
                  table.column(12).search('').draw();
               }
                else {
                  table.column(12).search($(this).val()).draw();
               }
             });

             $("#filter_gender").on("change", function() {
               var val = $(this).val();
               if(val == '*') {
                   table.column(3).search('').draw();
               }
               else {
                   table.column(3).search($(this).val()).draw();
               }
            });

            $("#filter_company").on("change", function() {
                var val = $(this).val();

                if(val == '*') {

                    table.column(14).search('').draw();
                }
                else {
                    table.column(14).search($(this).val()).draw();
                }
            });

            $("#companies").on("change", function() {
                var val = $(this).val();

                if(val == '*') {

                    table.column(5).search('').draw();
                }
                else {
                    table.column(5).search($(this).val()).draw();
                }
            });

            $("#contract_start").on("change", function() {
                var val = $(this).val();
                if(val == '*') {
                    table.column(10).search('').draw();
                }
               else {
                    table.column(10).search($(this).val()).draw();
                }
               });
            $('.dataTables_filter').find('input').addClass('form-control hr-input');
        });


    </script>
@endsection