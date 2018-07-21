{!! Form::myInput('text', 'name', 'Name') !!}

{!! Form::mySelect('type', 'Type', config('variables.sensorType')) !!}

{!! Form::mySelect('parent_id', 'Parent', $sensorsTable) !!}

{!! Form::myInput('text', 'place', 'Location') !!}
