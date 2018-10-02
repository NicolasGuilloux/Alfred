{!! Form::myInput('text', 'name', 'Username') !!}

{!! Form::myInput('email', 'email', 'Email') !!}

{!! Form::myInput('password', 'password', 'Password') !!}

{!! Form::myInput('password', 'password_confirmation', 'Password again') !!}

{!! Form::mySelect('role', 'Role', config('variables.role')) !!}

<hr class="m-30" />

{!! Form::myFile('avatar', 'Avatar') !!}

{!! Form::myInput('date', 'birthday', 'Birthday') !!}

{!! Form::myTextArea('bio', 'Bio') !!}

<div class="form-group">
    <label for="city">City</label>

    <p id="city_name">
        @if( isset(Auth::user()->city) )
            The current city is {{ Auth::user()->city->name }}, {{ Auth::user()->city->country }}.
        @endif
    </p>

    <p id="new_city_name" style="display: none;"></p>

    <input class="form-control" name="city" id="city" type="text" placeholder="Search a city" autocomplete="off">
</div>

{!! Form::myInput('hidden', 'accuweather_id') !!}

<table id="city_suggestions" class="table table-striped" style="display:none;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Area</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


@section('scripts')
    @parent

    <script>
        function searchCity() {
            var url = '{{ route('city.search', '') }}/' + encodeURIComponent( cityField.val() );
            console.log(url);

            $.getJSON(url, function(data) {
                console.log(url, data);

                lastData = data;
                $('#city_suggestions tbody').empty();
                $('#city_suggestions').fadeIn();

                for(var i=0; i<data.length; i++) {
                    var tr = document.createElement('tr');
                    tr.id = data[i]['Key'];
                    tr.className = 'table-hover';
                    tr.style = 'cursor:pointer;';
                    $('#city_suggestions').append(tr);

                    // Name
                    var td1 = document.createElement('td');
                    td1.innerText = data[i]['LocalizedName'];
                    tr.appendChild(td1);

                    // Country
                    var td2 = document.createElement('td');
                    td2.innerText = data[i]['Country']['LocalizedName']
                    tr.appendChild(td2);

                    // Area
                    var td3 = document.createElement('td');
                    td3.innerText = data[i]['AdministrativeArea']['LocalizedName'];
                    tr.appendChild(td3);
                }

                $('#city_suggestions tbody > tr').on('click', setCity)
            });

            clearTimeout(timer);
        }

        function setCity(evt) {
            cityId.val(evt.currentTarget.id);
            cityField.val('');
            $('#new_city_name').text('The new city name is ' + evt.currentTarget.children[0].innerText + ', ' + evt.currentTarget.children[1].innerText + '.').fadeIn();

            $('#city_suggestions').fadeOut();
        }

        var cityId = $('input[name=accuweather_id]');
        var cityField = $('input[name=city]');

        var timer = null;
        var lastData  = null;

        cityField.on('input', function() {
            if(timer)
                clearTimeout(timer);

            timer = setTimeout(searchCity, 500);
        });
    </script>
@endsection
