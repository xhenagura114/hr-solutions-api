@if($currentUser->hasAccess(["module.file-manager.home", "unisharp.lfm.*"]))
    @extends('filemanagermodule::layouts.file-manager-extendable',['pageTitle' => 'File Manager'])

@section('header-scripts')
    {{--add here additional header scripts--}}
@endsection


@section('content')
    <div class="container-fluid">
        <iframe src="/unisharp"
                style="width: 100%; height: calc(100vh - 130px); overflow: hidden; border: none;"></iframe>
    </div>
@endsection


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });
    </script>

    <script>
        var bodyClass = $('body').attr('class');
        $('iframe').on('load', function () {
            $('iframe').contents().find("body")
                .attr('class', bodyClass);
        });
    </script>
@endsection
@endif