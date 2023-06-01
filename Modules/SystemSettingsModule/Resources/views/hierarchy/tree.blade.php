@extends('systemsettingsmodule::layouts.system-settings-extendable',['pageTitle' => 'Hierarchy'])

@section('header-scripts')
    {{--add here additional header scripts--}}
    <link rel="stylesheet" href="{{asset("css/Treant.css")}}">

    <link rel="stylesheet" href="{{asset("css/basic-example.css")}}">

    <script src="{{asset("js/raphael.js")}}"></script>

    <script src="{{asset("js/Treant.js")}}"></script>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="hr-content pt-5 pb-5 full-wrapper tree-view">

            <div class="container-fluid pl-5">

                <div class="row ">
                    <div class="col">
                        <h5 class="hr-default-text mb-4">Organigram Hierarchy</h5>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 equal-height">
                    <div class="col-white">
                        <div class="hierarchy">

                            @foreach($departments_name as $department)
                                @if(is_null($department->parent_id))
                                    <div class="chart" id="basic-example_{{$department->id}}"></div>
                                @endif
                            @endforeach
                            <script>
                                $(window).bind("load", function () {
                                    $('.spinnerBackground').fadeOut(500);
                                });

                                var departments = {!! json_encode($departments_name) !!};

                                var tree = getNestedChildren(departments, null);

                                function getNestedChildren(arr, parent) {
                                    var out = [];
                                    for (var i in arr) {
                                        if (arr[i].parent_id === parent) {
                                            var children = getNestedChildren(arr, arr[i].id);

                                            if (children.length) {
                                                arr[i].children = children;
                                            }
                                            arr[i].text = {
                                                name: arr[i].name,
                                                color: arr[i].color
                                            };
                                            arr[i].HTMLid = arr[i].id;
                                            out.push(arr[i]);
                                        }
                                    }
                                    return out;
                                }
                                <?php $i = 0; ?>
                                @foreach($departments_name as $department)
                                    @if(is_null($department->parent_id))

                                        var tree_structure_{{$i}} = {
                                                chart: {
                                                    container: "#basic-example_{{$department->id}}",
                                                    siblingSeparation: 20,
                                                    subTeeSeparation: 20,
                                                    levelSeparation: 30,
                                                    rootOrientation: 'NORTH',
                                                    node: {
                                                        HTMLclass: "nodeExample1",
                                                        collapsable: true
                                                    },
                                                    connectors: {
                                                        type: 'step'
                                                    },
                                                    callback: {
                                                        // onTreeLoaded
                                                        onAfterPositionNode(node){
                                                            if(typeof node !== "undefined" && node.nodeHTMLid !== null){
                                                                $("#" + (parseInt(node.nodeHTMLid))).find('.node-name').css("background-color", node.text.color);
                                                                $("#" + (parseInt(node.nodeHTMLid))).css("background-color", node.text.color);
                                                            }
                                                        }
                                                    }
                                                },

                                                nodeStructure: tree[{!! $i !!}]
                                            };
                                        new Treant(tree_structure_{{$i}});
                                        {{$i++}}

                                    @endif
                                @endforeach


                            </script>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection