<input  type="text"
        name="{{ $id }}"
        class="datepicker text-center"
        id="{{ $id }}"
        placeholder="Click to select the date"
        readonly="readonly"
        size="25" />

@section('scripts')
    @parent

    <script>

        /**
         * Display a beautiful date
         *
         * @param String Date
         */
        function onSelect(evt) {
            // Display a pretty date
            var dateObj = new Date(evt);
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            $('#{{ $id }}').val( dateObj.toLocaleDateString('en-UK', options) );

            // Callback function
            @if( isset($onSelect) )
                {{ $onSelect }}(evt);
            @endif
        }

        /**
         * Enable or disable the date based on available dates
         *
         * @param Date Input date
         */
        function availableDays(date) {
            var dmy = date.getFullYear() + '-' + ("0" + (date.getMonth()+1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2);

            if ($.inArray(dmy, availableDates) != -1)
                return [true, "","Available"];

            return [false,"","unAvailable"];
        }

        // Array of date enabled
        @if( isset($availableDays) )
            var availableDates = {!! json_encode( $availableDays ) !!}
        @endif

        $('#{{ $id }}').val('');
        $('#{{ $id }}').datepicker({
            @if( isset($availableDays) )
                beforeShowDay: availableDays,
            @endif

            dateFormat: 'yy-mm-dd',
            onSelect: onSelect
        });
    </script>
@endsection
