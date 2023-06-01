@extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection


@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('systemsettingsmodule.name') !!}
    </p>
@endsection


@section('footer-scripts')
    {{--add here additional footer scripts--}}
@endsection