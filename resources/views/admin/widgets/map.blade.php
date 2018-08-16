<div class="masonry-item col-md-12">
    <div class="layers bd bgc-white p-20">
        <div class="layer w-100 mB-10">
            <div class="text-center mB-10">
                @include('admin.partials.datepicker', [
                    'id' => 'dateMap',
                    'onSelect' => 'getData',
                    'availableDays' => getJSON( env('APP_URL_SERVER') . '/api/available/dates' )
                ])
            </div>

            {!! file_get_contents( asset('images/world.svg') ) !!}

        </div>
    </div>
</div>

<div id="infobox" style="position: fixed; background-color: white; border: 1px solid black; display: none;"></div>

@section('scripts')
    @parent

    <script>
        var paths = $('svg path');
        var colors = ['#13a2bd', '#1e90a8', '#0d3841'];
        var defaultColor = $('svg path')[0].style.fill;
        var infobox = $('#infobox');

        /**
         * (AJAX) Get the data from the server
         */
        function getData(date) {
            $.getJSON('{!! env('APP_URL_SERVER') !!}/api/date/' + date, function(data) {
                displayData(data);
            });
        }

        /**
         * Display the data get from the server
         *
         * @param Array
         */
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

        /**
         * EventListener to show the infobox
         */
        window.onmousemove = function (e) {
            var x = e.clientX,
                y = e.clientY;

            if( $(e.target).attr('samples') ) {
                infobox.show();
                infobox[0].style.top = (y + 20) + 'px';
                infobox[0].style.left = (x + 20) + 'px';

                var element = $(e.target);

                infobox.html(
                    '<h4>'          + element.attr('title')     + '</h4>' +
                    'Samples: '     + element.attr('samples')   + ' people<br />' +
                    'Eletricity: '  + element.attr('electric')  + ' kWh<br />' +
                    'Water: '       + element.attr('water')     + ' L<br />' +
                    'Waste: '       + element.attr('waste')     + ' kg'
                );

            } else {
                infobox.hide();
            }

        };
    </script>
@endsection
