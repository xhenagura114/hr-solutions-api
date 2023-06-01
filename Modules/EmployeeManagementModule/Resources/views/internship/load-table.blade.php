<table class="table" id="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>University</th>
        <th>Level Of Education</th>
        <th>Education</th>
        <th>Phone Number</th>
        <th>Interests</th>
        <th>E-mail</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody id="internship">
    @foreach($internships as $internship)
        <tr class="applicant optiondep-{{$internship->id}} position-relative">
            <td>{{$internship->first_name}} {{$internship->last_name}}</td>
            <td>{{$internship->institution}}</td>
            <td>{{$internship->education}}</td>
            <td>{{$internship->studying_for}}</td>
            <td>{{isset($internship->contact) ? $internship->contact : ''}}</td>
            <td>{{$internship->interests != '' ? implode(", ", $internship->interests) : ''}}</td>
            <td><a href="mailto:{{isset($internship->email) ? $internship->email : ''}}">{{isset($internship->email) ? $internship->email : ''}}</a></td>
            <td>
                <button class="btn btn-sm hr-outline pull-right delete deleteInternship" type="button" id="{{$internship->id}}"><i class="fa fa-trash-o"></i></button>
                <button class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;" onclick="editInternship({{$internship->id}})"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm hr-outline pull-right" style="margin-right: 3px;" onclick="approveInternship({{$internship->id}})"><i class="fa fa-check-square-o"></i></button>
            </td>
        </tr>
    @endforeach
</table>

<script>
    $(document).ready(function () {

        var table = $('#table').DataTable({
            "pageLength": 15
        });

        $('#myInputTextField').keyup(function () {
            table.search($(this).val()).draw();
        })

    });

    $(".deleteInternship").click(function () {
        var id = parseInt($(this).attr("id"));
        var url = '{{ route("module.internship.destroy", ":id") }}';
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
