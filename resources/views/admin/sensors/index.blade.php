@extends('admin.default')

@section('page-header')
    Sensors <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

@if( Auth::user()->role > 9 )
    <div class="mB-20">
        <a href="{{ route('sensors.create') }}" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h3>Electricity</h3>

            @foreach( $items[0] as $key => $item )
                <div id="tree0-{{ $key }}" width="{{ 100/sizeof($items[0]) }}%"></div>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h3>Waste</h3>

            @foreach( $items[1] as $key => $item )
                <div id="tree1-{{ $key }}" width="{{ 100/sizeof($items[1]) }}%"></div>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h3>Water</h3>

            @foreach( $items[2] as $key => $item )
                <div id="tree2-{{ $key }}" width="{{ 100/sizeof($items[2]) }}%"></div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/js/jit.js') }}"></script>

    <script>
        function createTree(container, json){

            // A client-side tree generator
            var getTree = (function() {
                var i = 0;
                return function(nodeId, level) {

                    var subtree = eval('(' + json.replace(/id:\"([a-zA-Z0-9]+)\"/g,

                    function(all, match) {
                        return "id:\"" + match + "_" + i + "\""
                    }) + ')');

                    $jit.json.prune(subtree, level); i++;
                    return {
                        'id': nodeId,
                        'children': subtree.children
                    };
                };
            })();

            //init Spacetree
            //Create a new ST instance
            var st = new $jit.ST({
                injectInto: container,

                height: 200,

                orientation: 'top',
                offsetY: 90,

                levelsToShow: 2,
                levelDistance: 50,

                //set node and edge styles
                //set overridable=true for styling individual
                //nodes or edges
                Node: {
                    width: 100,

                    color: 'rgba(0, 0, 0, 0)',
                    lineWidth: 1,
                    align: "center"
                },

                Edge: {
                    type: 'bezier',
                    lineWidth: 1,
                    color: '#00bcd4'
                },

                //This method is called on DOM label creation.
                //Use this method to add event handlers and styles to
                //your node.
                onCreateLabel: function(label, node){
                    label.id = node.id;
                    label.innerHTML = node.name;
                    label.onclick = function(){
                        document.location.href = node.data.href;
                    };

                    //set label styles
                    var style = label.style;
                    style.width = 100 + 'px';
                    style.cursor = 'pointer';
                    style.color = '#fff';

                    style.backgroundColor = '#00BCD4';
                    style.borderRadius = '.25rem';
                    style.fontSize = '.85em';
                    style.textAlign= 'center';
                    style.padding = '0.5em';
                },
            });

            //load json data
            st.loadJSON(eval( '(' + json + ')' ));

            //compute node positions and layout
            st.compute();

            //emulate a click on the root node.
            st.onClick(st.root);
        }

        // Create trees
        @for ($i = 0; $i < 3; $i++)
            @foreach( $items[0] as $key => $item )
                createTree('tree{{$i}}-{{$key}}', '{!! json_encode( $items[$i][$key] ) !!}');
            @endforeach
        @endfor


    </script>
@endsection
