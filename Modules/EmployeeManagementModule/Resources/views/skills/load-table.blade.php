<table class="table" id="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Skill</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody id="skills">
    @foreach($records as $skill)
        <tr class="applicant position-relative">
            <td>{{$skill['first_name']}} {{$skill['last_name']}}</td>
            <td><a href="mailto:{{isset($skill->email) ? $skill->email : ''}}">{{$skill['email']}}</a></td>
            <td>{{$skill['mobile']}}</td>
            <td>{{$skill['skill']}}</td>
            <td class="text-right">{{$skill['type']}}</td>
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
        });

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
</script>
