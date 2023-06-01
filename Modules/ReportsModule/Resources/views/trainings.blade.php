<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Table Demo</div>

                    <div class="panel-body">
                        <table id="trainings" class="table table-hover table-bordered table-striped datatable display" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Birthday</th>
                                <th>Education</th>
                                <th>Status</th>
                                <th>Contract Start</th>
                                <th>Contract End</th>
                                <th>Department</th>
                                <th>Job Position</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            var training_table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                '<th>Training</th>'+
                '<th>Description</th>'+
                '<th>Start Date</th>'+
                '<th>End Date</th>'+
                '<th>Training Department</th>'+
                '</tr>';

            for (var i = 0; i < d.length; i++)
                training_table += '<tr>'+
                    '<td>' + d[i].title + '</td>'+
                    '<td>' + d[i].training_description + '</td>'+
                    '<td>' + d[i].start_date + '</td>'+
                    '<td>' + d[i].end_date + '</td>'+
                    '<td>' + d[i].departments.name + '</td>'+
                    '</tr>';

            training_table += '</table>';

            return training_table;
        }

        $(document).ready(function() {
            var table = $('#dataTableBuilder').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('module.reports.get-trainings-ajax') }}',
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '<button>Show</button>'
                    },
                    {data: 'id', name: 'id'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'birthday', name: 'birthday'},
                    {data: 'education', name: 'education'},
                    {data: 'status', name: 'status'},
                    {data: 'contract_start', name: 'contract_start'},
                    {data: 'contract_end', name: 'contract_end'},
                    {data: 'departments.name', name: 'departments.name'},
                    {data: 'jobs.title', name: 'jobs.title'},
                ],

                'columnDefs': [
                    {
                        'targets': 8,
                        'visible': true,
                        "searchable": true,
                        "render": function (data, type, row) {
                            if(typeof  data === "undefined")
                                return ' ';
                            return data;
                        },
                    },
                    {
                        'targets': 9,
                        'visible': true,
                        "searchable": true,
                        "render": function (data, type, row) {
                           if(typeof  data === "undefined")
                             return ' ';
                           return data;
                        },
                    },
                ]
            });
            // Add event listener for opening and closing details
            $('#trainings tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data().user_trainings) ).show();
                    tr.addClass('shown');
                }
            });
        });



    </script>
