@extends('selfservicemodule::layouts.self-service-extendable',['pageTitle' => 'Self-Service'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection


@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('selfservicemodule.name') !!}
    </p>
@stop


@section('footer-scripts')
    {{--add here additional footer scripts--}}
@endsection