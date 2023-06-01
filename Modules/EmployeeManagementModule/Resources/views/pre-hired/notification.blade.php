@extends('layouts.wrapper', ['pageTitle' => 'Pre-hired Notification'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection

@section('content')

    <div class="container-fluid">
        <div class="hr-content pt-3 pb-3">

            @if(Session::get("message"))
                <div class="alert alert-success"><em> {{ Session::get("message") }}</em></div>
            @endif

            <p>Today</p>
            <table class="table dataTable text-center">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Position</th>

                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td> {{ $user->id }}</td>
                        <td> {{ $user->first_name }}</td>
                        <td> {{ $user->last_name }}</td>
                        <td> {{ $user->email }}</td>
                        <td> {{isset($user->jobVacancies->position) ? $user->jobVacancies->position : ''}} </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
            <hr />
            <p class="mt-4">Upcoming</p>
            <table class="table dataTable text-center">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($applicant_upcoming as $user)
                    <tr>
                        <td> {{ $user->id }}</td>
                        <td> {{ $user->first_name }}</td>
                        <td> {{ $user->last_name }}</td>
                        <td> {{ $user->email }}</td>
                        <td> {{isset($user->jobVacancies->position) ? $user->jobVacancies->position : ''}} </td>
                        <td> {{ $user->quit_date }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
@endsection
