<div class="masonry-item col-md-12">
    <div class="layers bd bgc-white p-20">
        <div class="layer w-100 mB-10">
            <div class="text-center">
                <input type="date" name="date" />
            </div>
            {!! file_get_contents( asset('images/world.svg') ) !!}
        </div>
    </div>
</div>

<div id="infobox" style="position: fixed; background-color: white; border: 1px solid black;"></div>

@section('scripts')
    @parent

    <script>
        var paths = $('svg path');
        var colors = ['#13a2bd', '#1e90a8', '#0d3841'];
        var defaultColor = $('svg path')[0].style.fill;

        function getData() {
            var date = $('input[type="date"]').val();
            $.getJSON('{!! env('APP_URL_SERVER') !!}/api/date/' + date, function(data) {
                displayData(data);
            })
        }

        function displayData(data) {
            var colorIndex = 0;

            // Cleans everything
            if(!data) {
                console.log('No data for this day');
                for(var i=0; i<paths.length; i++) {
                    var path = paths[i];

                    $(path).removeAttr('electric');
                    $(path).removeAttr('waste');
                    $(path).removeAttr('water');
                    $(path).removeAttr('samples');
                    path.style.fill = defaultColor;
                }

                return;
            }

            // Set the new values
            for(var i=0; i<paths.length; i++) {
                var path = paths[i];
                var country = $(path).attr('title');

                if(country) {

                    if(data[country]) {
                        $(path).attr('electric',    data[country]['electric']);
                        $(path).attr('waste',       data[country]['waste']);
                        $(path).attr('water',       data[country]['water']);
                        $(path).attr('samples',     data[country]['samples']);
                        path.style.fill = colors[colorIndex];
                        colorIndex = (colorIndex +1) % (colors.length);

                    } else {
                        $(path).removeAttr('electric');
                        $(path).removeAttr('waste');
                        $(path).removeAttr('water');
                        $(path).removeAttr('samples');
                        path.style.fill = defaultColor;
                    }
                }
            }
        }

        var infobox = $('#infobox');

        window.onmousemove = function (e) {
            var x = e.clientX,
                y = e.clientY;

            if( $(e.target).attr('samples') ) {
                infobox.show();
                infobox[0].style.top = (y + 20) + 'px';
                infobox[0].style.left = (x + 20) + 'px';

                infobox.html(
                    'Samples: '     + $(e.target).attr('samples')   + ' people<br />' +
                    'Eletricity: '  + $(e.target).attr('electric')  + ' kWh<br />' +
                    'Water: '       + $(e.target).attr('water')     + ' L<br />' +
                    'Waste: '       + $(e.target).attr('waste')     + ' kg'
                );

            } else {
                infobox.hide();
            }

        };

        getData();
        $('input[type="date"]').on('change', getData);
    </script>
@endsection
