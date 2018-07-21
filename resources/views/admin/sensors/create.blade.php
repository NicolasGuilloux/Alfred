@extends('admin.default')

@section('page-header')
  Sensor <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
    {!! Form::open([
        'action' => ['SensorController@store'],
        'files' => true
      ])
    !!}

    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                @include('admin.sensors.form')

                <button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
            </div>
        </div>
    </div>

  {!! Form::close() !!}


@stop
