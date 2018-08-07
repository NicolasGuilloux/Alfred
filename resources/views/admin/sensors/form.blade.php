{!! Form::myInput('text', 'name', 'Name') !!}

{!! Form::mySelect('driverName', 'Driver Name', $drivers) !!}

{!! Form::mySelect('parent_id', 'Parent', $sensorsTable) !!}

{!! Form::myInput('text', 'place', 'Location') !!}

@section('scripts')
    @parent

    <script>
        $('select#driverName').on('change', function() {
            $('select#parent_id').val('0');

            if( !$('select#parent_id').prop('disabled') ) {
                $('select#parent_id').prop('disabled', true);
                $('label[for="parent_id"]')[0].innerText += " (Save the changes before changing this option)";
            }
        });
    </script>
@endsection
