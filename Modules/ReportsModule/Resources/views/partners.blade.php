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

           
            $('.dataTables_filter').find('input').addClass('form-control hr-input');
        });


    </script>
@endsection