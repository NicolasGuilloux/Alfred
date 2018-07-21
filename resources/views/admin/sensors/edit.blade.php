@extends('admin.default')

@section('page-header')
  Sensor <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
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

    @if(sizeof($item->reports) > 0 )

        <div class="row mB-40">
            <div class="col-sm-12">
                <div class="bgc-white p-20 bd">
                    <h2>Reports</h2>

                    <p>
                        Choose a date to visualise the data:
                        <input  type="date"
                                name="date"
                                id="datePicker"
                                value="jj/mm/aaaa"
                                min="{{ $item->reports[0]['date'] }}"
                                max="{{ $item->reports[ sizeof($item->reports) -1 ]['date'] }}"
                        />
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
