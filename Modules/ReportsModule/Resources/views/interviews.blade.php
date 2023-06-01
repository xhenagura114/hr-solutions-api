@extends('reportsmodule::layouts.master', ['pageTitle' => 'Reports'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{asset('js/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <script src="{{ asset("js/parsley.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
@endsection
@section('content')
    <!-- <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

    <div class="container-fluid reports-page">
        <div class="hr-content pt-4 pb-4">

            <div class="h-100 pl-4 pr-4 scroll">

                <div class="ml-3 mt-4 mb-5">
                    <b class="hr-default-text d-block">Reports</b>
                </div>
                <div class="row align-items-end mb-5">
                    <div class="col-lg-3 col-md-6">
                        <select class="selectpicker hr-input" data-live-search="true" id="filtersReport">
                            <option value="*">All Vacancies</option>
                            @foreach ($job_vacancies as $position)
                                @if($position->job_vacancy_id)
                                    <option value="{{$position->jobVacancies->position}}">
                                        {{$position->jobVacancies->position}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <form class="row align-items-end col-lg-8 mx-2" action="{{route('module.reports.interviews')}}" method="get">
                        <div class="col-lg-5 col-md-6 pr-5">
                            <select class="selectpicker hr-input" data-live-search="true" id="applicantSkillReport" name="applicantSkillReport">
                                <option value="*">Select skill</option>
                                @foreach ($skills as $skill)
                                    @if($skill->title != Null)
                                        <option value="{{$skill->title}}" @if(request()->input('applicantSkillReport') == $skill->title) selected="selected" @endif>
                                            {{$skill->title}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-5 col-md-6 pr-5">
                            <select class="selectpicker hr-input" data-live-search="true" id="applicantSeniorityReport" name="applicantSeniorityReport">
                                <option value="*">Select skill seniority</option>
                                @foreach ($seniority as $senior)
                                    <option value="{{$senior}}" @if(request()->input('applicantSeniorityReport') == $senior) selected="selected" @endif>
                                        {{$senior}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-primary cv-download" onclick="generateZIP()" disabled>Download selected CV(s)</button>
                        </div>
                    </form>
                </div>
                <div class="row align-items-end mb-5">
                    <form class="row align-items-end col-lg-6" action="{{route('module.reports.interviews')}}" method="get">
                        <div class="col-lg-6 col-md-6">
                           <select class="selectpicker hr-input" data-live-search="true" id="applicantPossiblePositionReport" name="applicantPossiblePositionReport">
                               <option value="*">Select position evaluation</option>
                               @foreach ($applicant_position as $app)
                                    @if($app->possible_position != Null)
                                        <option value="{{$app->possible_position}}" @if(request()->input('applicantPossiblePositionReport') == $app->possible_position) selected="selected" @endif>
                                            {{$app->possible_position}}
                                            </option>
                                        @endif
                                     @endforeach
                                </select>
                            </div>
                        <div class="col-lg-6 col-md-6">
                            <select class="selectpicker hr-input" data-live-search="true" id="applicantSeniorityEvaluationReport" name="applicantSeniorityEvaluationReport">
                                <option value="*">Select seniority evaluation</option>
                                @foreach ($applicant_seniority as $app)
                                    @if($app->seniority != Null)
                                        <option value="{{$app->seniority}}" @if(request()->input('applicantSeniorityEvaluationReport') == $app->seniority) selected="selected" @endif>
                                            {{$app->seniority}}
                                        </option>
                                     @endif
                                @endforeach
                            </select>
                        </div>
                     </form>
                </div>
              {!! $dataTable->table(['class' => 'text-center', 'id'=> 'tableReport']) !!}
            </div>


        </div>
</div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

    <script src="/vendor/datatables/buttons.server-side.js"></script>

    {!! $dataTable->scripts() !!}
@endsection

@section('footer-scripts')
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        setTimeout(function () {
            $(".alert-success").slideUp(500);
        }, 2000);
        // Change in skills or seniority, remove selected value in All Vacancies

    </script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-eu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js" integrity="sha256-gy5W5/rXWluWXFRvMWFFMVhocfpBe7Tf4SW2WMfjs4E=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.1.0/jszip-utils.min.js" integrity="sha256-5GhqDpPB1bpRluB0hmS7EJkMH+EVyqUP00CvFEksTVw=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script>
    var links = [];
        $(document).ready(function () {

            
            $(document).on('click', 'input[type="checkbox"]', function() {
                if( $(this).is(':checked') ) {
                    links.push($(this).next().attr('href'));
                } else {
                    var itemtoRemove = $(this).next().attr('href');
                    links.splice($.inArray(itemtoRemove, links), 1);
                }

                if(links.length != 0) {
                    $('.cv-download').prop("disabled", false);
                } else {
                    $('.cv-download').prop("disabled", true);
                }
            });

            var table = $('#tableReport').DataTable();

            $('#myInputTextField').keyup(function () {
                table.search($(this).val()).draw();
            });

            $("#filtersReport").on("change", function() {
                var val = $(this).val();

                if(val == '*') {

                    table.column(7).search('').draw();
                }
                else {
                    table.column(7).search($(this).val()).draw();
                }
            });

            function changeSelect(select) {
                $(select).on('change', function() {
                    $(this).parents('form').submit();
                });
            }

            changeSelect('#applicantSkillReport');
            changeSelect('#applicantSeniorityReport');
            changeSelect('#applicantPossiblePositionReport');
            changeSelect('#applicantSeniorityEvaluationReport');

            $('.dataTables_filter').find('input').addClass('form-control hr-input');
        });

        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-eu-pre": function ( date ) {
                date = date.replace(" ", "");

                if ( ! date ) {
                    return 0;
                }

                var year;
                var eu_date = date.split(/[\.\-\/]/);

                /*year (optional)*/
                if ( eu_date[2] ) {
                    year = eu_date[2];
                }
                else {
                    year = 0;
                }

                /*month*/
                var month = eu_date[1];
                if ( month && month.length == 1 ) {
                    month = 0+month;
                }

                /*day*/
                var day = eu_date[0];
                if ( day && day.length == 1 ) {
                    day = 0+day;
                }

                return (year + month + day) * 1;
            },

            "date-eu-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        } );

        function generateZIP() {
            var zip = new JSZip();
            var count = 0;
            var zipFilename = "CV List.zip";

            links.forEach(function (url, i) {
                var filename = links[i];

                // get protocol and domain, we need these to remove below with regex, because these appear on filename
                var protocol = location.protocol.replace(':', '');
                var domain = window.location.hostname + 'docs';

                // default filename is http(s) + domain + docs + filename, we only need filename
                filename = filename.replace(/[\/\*\|\:\<\>\?\"\\\d{14}_]/gi, '').replace(protocol + domain,"");
                
                // loading a file and add it in a zip file
                JSZipUtils.getBinaryContent(url, function (err, data) {
                    if (err) {
                        swal(
                            'Error!',
                            'At least one of the selected CVs doesn\'t exist.' ,
                            'error'
                        );
                        throw err; // or handle the error
                    }
                    zip.file(filename, data, { binary: true });
                    count++;
                    if (count == links.length) {
                        zip.generateAsync({ type: 'blob' }).then(function (content) {
                        saveAs(content, zipFilename);
                        });
                    }
                });
            });
        }

    </script>

@endsection