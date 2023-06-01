<table class="table" id="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone number</th>
        <th>Interview date</th>
        <th>Applied for</th>
        <th>Preliminary form</th>
        <th>Scan form</th>
        <th>CV Download</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody id="applicants">
    @foreach($applicants as $applicant)

        <tr class="applicant optiondep-{{$applicant->job_vacancy_id}} position-relative">
            <td>{{$applicant->first_name}} {{$applicant->last_name}}</td>
            <td>{{isset($applicant->contact) ? $applicant->contact : ''}}</td>
            <td>{{ $applicant->interview_date }}</td>
            <td>{{isset($applicant->jobVacancies->position) ? $applicant->jobVacancies->position : ''}}</td>
            <td>
                <button class="btn btn-small btn-primary" onclick="devApplicant({{$applicant->id}})">Dev</button>
                <button class="btn btn-small btn-primary" onclick="devOpsApplicant({{$applicant->id}})">DevOps</button>
                <button class="btn btn-small btn-primary" onclick="estimationApplicant({{$applicant->id}})">Evaluation
                </button>
            </td>
            @if(isset($applicant->form_path) and $applicant->form_path != '' )
                <td><a href="{{asset('/').$applicant->form_path}}">View scan</a></td>
            @else
                <td>Empty</td>
            @endif
            <td>
                @if(isset($applicant->cv_path))
                    <a href="{{ asset('/').$applicant->cv_path }}" target="_blank"><i class="fa fa-download"></i> Download CV</a>
                @else
                    Not provided
                @endif
            </td>
            <td>
                <button class="btn btn-sm hr-outline pull-right delete deleteApplicant" type="button"
                        id="{{$applicant->id}}"><i class="fa fa-trash-o"></i></button>
                <button class="btn btn-sm hr-outline pull-right" style="margin-right: -2px;"
                        onclick="editApplicant({{$applicant->id}})"><i class="fa fa-edit"></i></button>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script src="{{asset('js/moment.min.js')}}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-eu.js"></script>
<script>
    $(document).ready(function () {

        let table = $('#table').DataTable({
            "pageLength": 15,
            "order": [[2, "acs"]],
            'columnDefs': [
                {
                    "type": "date-eu",
                    'targets': 2,
                    "render": function (data, type, row) {
                        return data;
                    },
                }
            ],
        });

        $('#myInputTextField').keyup(function () {
            table.search($(this).val()).draw();
        });

        $("#filters").on("change", function () {
            var val = $(this).val();

            if (val == '*') {

                table.column(3).search('').draw();
            } else {
                table.column(3).search($(this).val()).draw();
            }
        });
    });


    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-eu-pre": function (date) {
            date = date.replace(" ", "");

            if (!date) {
                return 0;
            }

            var year;
            var eu_date = date.split(/[\.\-\/]/);

            /*year (optional)*/
            if (eu_date[2]) {
                year = eu_date[2];
            } else {
                year = 0;
            }

            /*month*/
            var month = eu_date[1];
            if (month && month.length == 1) {
                month = 0 + month;
            }

            /*day*/
            var day = eu_date[0];
            if (day && day.length == 1) {
                day = 0 + day;
            }

            return (year + month + day) * 1;
        },

        "date-eu-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-eu-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });

    $(".deleteApplicant").click(function () {
        var id = parseInt($(this).attr("id"));
        var url = '{{ route("module.interviews.destroy", ":id") }}';
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
        }).then(function (result) {
            if (result.value) {
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
