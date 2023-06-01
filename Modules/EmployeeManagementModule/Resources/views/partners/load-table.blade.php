<table class="table" id="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Birthday</th>
        <th>Phone Number</th>
        <th>Company</th>
        <th>Job Position</th>
        <th>E-mail</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody id="partners">
    @foreach($partners as $partner)
        <tr class="applicant optiondep-{{$partner->id}} position-relative">
            <td>{{$partner->first_name}} {{$partner->last_name}}</td>
            <td>{{(date('d-m-Y') !== $partner->birthday) ? $partner->birthday : ''}}</td>
            <td>{{$partner->contact}}</td>
            <td>{{$partner->company}}</td>
            <td>{{$partner->job_position}}</td>
            <td><a href="mailto:{{isset($partner->email) ? $partner->email : ''}}">{{isset($partner->email) ? $partner->email : ''}}</a></td>
            <td>
                <button class="btn btn-sm hr-outline pull-right delete deletePartner" type="button" id="{{$partner->id}}"><i class="fa fa-trash-o"></i></button>
                <button class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;" onclick="editPartner({{$partner->id}})"><i class="fa fa-edit"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script src="{{asset('js/moment.min.js')}}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-eu.js"></script>
<script>
    $(document).ready(function () {

        var table = $('#table').DataTable({
            "pageLength": 15,
            'columnDefs': [
                {
                    "type": "date-eu",
                    'targets': 1,
                    "render": function (data, type, row) {
                        return data;
                    },
                }
            ],
        });

        $('#myInputTextField').keyup(function () {
            table.search($(this).val()).draw();
        })

    });

    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-eu-pre": function ( date ) {
            date = date.replace(" ", "");
            if ( ! date ) {
                return 0;
            }

            var year = 0;
            var eu_date = date.split(/[\.\-\/]/);

            /*year (optional)*/
            // if ( eu_date[2] ) {
            //     year = eu_date[2];
            // }
            // else {
            //     year = 0;
            // }

            /*month*/
            var month = eu_date[1];
            if ( month && month.length == 1 ) {
                month = 0+month;
            }

            /*day*/
            var day = eu_date[0];
            if ( day && day.length == 1 ) {
                day = 0+day;
            }

            return (year + month + day) * 1;
        },

        "date-eu-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-eu-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );

    $(".deletePartner").click(function () {
        var id = parseInt($(this).attr("id"));
        var url = '{{ route("module.partners.destroy", ":id") }}';
        url = url.replace(':id', id);
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
                    url: url,
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
