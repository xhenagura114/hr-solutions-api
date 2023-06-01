@extends('layouts.wrapper', ['pageTitle' => 'Birthdays'])

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
                    <th>Type</th>
                    <th>Company</th>
                    <th>Position</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td> {{ $user->id }}</td>
                        <td> {{ $user->first_name }}</td>
                        <td> {{ $user->last_name }}</td>
                        <td> {{ $user->email }}</td>
                        <td> Employee </td>
                        <td> {{ isset($user->departments->name) ? $user->departments->name : '' }} </td>
                        <td> {{ isset($user->jobs->title) ? $user->jobs->title : '' }} </td>
                        <td class="text-right"> <a href="make-wish/user/{{ $user->id }}"> Make a wish </a> </td>
                    </tr>
                @endforeach
                @foreach($partners as $user)
                    <tr>
                        <td> {{ $user->id }}</td>
                        <td> {{ $user->first_name }}</td>
                        <td> {{ $user->last_name }}</td>
                        <td> {{ $user->email }}</td>
                        <td> Partner </td>
                        <td> {{ $user->company }} </td>
                        <td> {{ $user->job_position }} </td>
                        <td class="text-right"> <a href="make-wish/partner/{{ $user->id }}"> Make a wish </a> </td>
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
                    <th>Type</th>
                    <th>Company</th>
                    <th>Position</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users_upcoming as $user)
                <tr>
                    <td> {{ $user->id }}</td>
                    <td> {{ $user->first_name }}</td>
                    <td> {{ $user->last_name }}</td>
                    <td> {{ $user->email }}</td>
                    <td> Employee </td>
                    <td> {{ isset($user->departments->name) ? $user->departments->name : '' }} </td>
                    <td> {{ isset($user->jobs->title) ? $user->jobs->title : '' }} </td>
                    <td> {{ $user->birthday }}</td>
                </tr>
            @endforeach
            @foreach($partners_upcoming as $user)
                <tr>
                    <td> {{ $user->id }}</td>
                    <td> {{ $user->first_name }}</td>
                    <td> {{ $user->last_name }}</td>
                    <td> {{ $user->email }}</td>
                    <td> Partner </td>
                    <td> {{ $user->company }} </td>
                    <td> {{ $user->job_position }} </td>
                    <td> {{ $user->birthday }}</td>
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
