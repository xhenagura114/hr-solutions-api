@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

<table class="table" id="table">

    <thead>
    <tr>
        <th>Name</th>
        <th>Dates</th>
        <th style="display: none">Year</th>
        <th>Working days</th>
        <th>Reason</th>
        {{--        <th>Department</th>--}}
        <th>Company</th>
        @if($currentUser->hasAnyAccess(["module.requests.history-edit", "module.requests.delete-request"]))
            <th class="text-left">Action</th>
        @endif
    </tr>
    </thead>

    <tbody class="pendingRequest">
    <div class="w-100 filters">
        <div class="btn-group btn-group-toggle filter-buttons" id="filters" data-toggle="buttons">
            <label class="btn btn-light all active">
                <input type="radio" name="options" id="all" autocomplete="off" data-filter="*" checked> All
            </label>

            @foreach ($years as $year)
                @foreach ($year as $y)
                    <label class="btn btn-light">
                        <input type="radio" name="options" id="optiondep-{{$y}}"
                               autocomplete="off" data-filter=".optiondep-{{$y}}"
                               checked> {{$y}}
                    </label>
                @endforeach
            @endforeach

        </div>
    </div>
    <br>
    @foreach($requests as $request)

        <tr id="{{$request->id}}">
            <td>{{$request->user->full_name}}</td>
            <td>{{$request->start_date_no_time}} :: {{$request->end_date_no_time}}
            </td>
            <td style="display: none">{{ $request->year }}</td>
            <td> {{$request->working_days}}</td>
            <td>{{$request->reason}}</td>
            {{--            <td>{{$request->user->departments->name}}</td>--}}
            <td>{{$request->user->company}}</td>
            <td>
                @if($currentUser->hasAccess(["module.requests.history-edit"]))
                    <a href="javascript:void(0);"
                       class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;"
                       onclick="editHoliday({{$request->id}})"><i class="fa fa-edit"></i></a>
                @endif

                @if($currentUser->hasAccess("module.requests.delete-request"))
                    <a href="javascript:void(0);"
                       onclick="deleteRequest({{$request->id}})"
                       class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;">
                        <i class="fa fa-trash-o"></i></a>
                @endif
            </td>
        </tr>
    @endforeach

    </tbody>

</table>

<script>
    $(document).ready(function () {

        let search = '',
            val = '';

        let table = $('#table').DataTable({
            "pageLength": 15
        });

        // In both cases (search and year button), filter both fields,
        // that's why there are two .search() functions

        $('#myInputTextField').keyup(function () {
            console.log(val);
            search = $(this).val();
            table
                .search(val)
                .column(0)
                .search(search)
                .draw();
        });

        $('#filters').on('click', '.btn', function() {
            val = $(this).text().trim();

            if(val == 'All') {
                val = '';
            }

            table.search(val).column(0).search(search).draw();
        });

        $('#filter_company').change(function () {
            let company = $(this).val();
            table
                .columns(5)
                .search(company)
                .draw();
        });

    });
</script>