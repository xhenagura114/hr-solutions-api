@extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'System Settings'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection


@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-5 pb-5">

            <div class="container-fluid">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ Form::open([ 'route' => ['system-settings.departments.update', $department->id], 'method' => 'PUT' ,'class' => 'row text-center' ]) }}
                <div class="col-md-3 align-self-center">
                    {{ Form::label('parent_department_id', 'Select Parent Department') }}
                    {{ Form::select('parent_department_id', $departments->pluck('name', 'id'), $department->parent_id, ['class' => 'form-control','placeholder' => 'Pick a parent department...']) }}
                </div>

                <div class="col-md-3 align-self-center">
                    {{ Form::label('department_name', 'New Department Name') }}
                    {{ Form::text('department_name', $department->name, array('class' => 'form-control', 'placeholder' => 'Insert a department name...', 'required'=>'required')) }}
                </div>

                {{ Form::submit('Edit', array('class' => 'btn btn-primary align-self-center')) }}
                {{ Form::close() }}

            </div>
        </div>
    </div>

@endsection


@section('footer-scripts')
    {{--add here additional footer scripts--}}
@endsection