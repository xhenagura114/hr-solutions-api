@extends('layouts.wrapper', ['pageTitle' => 'Birthdays'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection

@section('content')
<div>
    {{ Session::get("message") }}
</div>

<table>
    <thead>
       <tr>
           <th>Id</th>
           <th>First name</th>
           <th>Last name</th>
           <th>Email</th>
           <th>Age</th>
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
                <td> {{ \Carbon\Carbon::parse($user->birthday)->diffInYears(\Carbon\Carbon::now())  }}</td>
                <td> <a href="make-wish/{{ $user->id }}"> Make a wish </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>
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
