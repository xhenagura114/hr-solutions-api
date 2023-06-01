@extends('layouts.wrapper')

@section('module-layout-header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/sweetalert2.min.js") }}"></script>
@endsection

@section('side-navigation-menu')

    <li class="side-menu-item">
        <a href="javascript:void(0)">
             <span class="default-color">
                 <i class="fa fa-calendar"></i>&nbsp;
                 Agenda
             </span>
        </a>
    </li>

@endsection