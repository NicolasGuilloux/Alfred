@extends('admin.default')

@section('page-header')
  Sensor <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')

    @if( Auth::user()->role > 9 )
        {!! Form::model($item, [
            'action' => ['SensorController@update', $item->id],
            'method' => 'put'
          ])
        !!}

        <div class="row mB-40">
            <div class="col-sm-8">
                <div class="bgc-white p-20 bd">
                    @include('admin.sensors.form')

                    <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    @else
        <div class="row mB-40">
            <div class="col-sm-8">
                <div class="bgc-white p-20 bd">
                    <table class="table table-hover">
                        <tr>
                            <th class="row">Name</td>
                            <td>{{ $item->name }}</td>
                        </tr>
                        <tr>
                            <th class="row">Driver Name</td>
                            <td>{{ $item->driverName }}</td>
                        </tr>
                        <tr>
                            <th class="row">Parent</td>
                            <td>{{ $item->parent_id ? $item->parent_id : "None" }}</td>
                        </tr>
                        <tr>
                            <th class="row">Location</td>
                            <td>{{ $item->place }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if(sizeof($item->reports) > 0 )

        <div class="row mB-40">
            <div class="col-sm-12">
                <div class="bgc-white p-20 bd">
                    <h2>Reports</h2>

                    <p>
                        Choose a date to visualise the data:
                        @include('admin.partials.datepicker', [
                            'id' => 'datePicker',
                            'onSelect' => 'getChart',
                            'availableDays' => getJSON( env('APP_URL_SERVER') . '/api/available/dates' )
                        ])
                    </p>

                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>

    @endif
@stop

@if(sizeof($item->reports) > 0 )
    @section('scripts')
        @parent

        <script>
            var sensor_id = {{ $item->id }};
        </script>

        <script src=//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js charset=utf-8></script>
        <script src="{{ asset('assets/js/chart.js') }}"></script>
    @endsection
@endif
