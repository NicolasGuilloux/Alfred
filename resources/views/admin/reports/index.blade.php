@extends('admin.default')

@section('head')
    <script src=//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js charset=utf-8></script>
@endsection

@section('page-header')
    Reports <small>View</small>
@endsection

@section('content')

    <div class="row justify-content-md-center">
        <div class="col-md-6 text-center">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <p>
                    Choose a date to visualise the data and validate:
                </p>

                {!! Form::open([
                    'action' => ['ReportController@show', '%date%'],
                    'method' => 'get'
                  ])
                !!}

                    <input  type="date"
                            id="datePicker"

                            @if( isset($currentDate) )
                                value="{{ $currentDate }}"
                            @else
                                value="jj/mm/aaaa"
                            @endif

                            min="{{ $minDate }}"
                            max="{{ $maxDate }}"

                            required
                    />

                    <input type="submit" />

                {!! Form::close() !!}

                @if( isset($reports) )
                    <hr />

                    @if( sizeof($reports) == 0)
                        <p>
                            There is no report stored for this day.
                        </p>

                    @else

                        <p>
                            @if( sizeof($reports) == 1)
                                There is only <strong>1 report</strong>
                            @else
                                There are <strong>{{ sizeof($reports) }} reports</strong>
                            @endif
                             for the <strong>{{ date('j \o\f F Y', strtotime($currentDate) ) }}</strong>.
                        </p>

                    @endif
                @endif
            </div>
        </div>
    </div>

    @if( isset($dailyReport) )
        <!-- Small tiles -->

        <div class="row gap-20 m-20">
            @foreach( config('variables.sensorType') as $key => $type)
                    @include('admin.widgets.board', $dailyReport->chartReport($key))
            @endforeach
        </div>

        <!-- Details charts -->
        <div class="row justify-content-md-center">

            @foreach($dailyReport->reports as $report)

                @if( $report->sensor->type == 0 )
                    @include('admin.reports.partials.electric', $report)

                @elseif( $report->sensor->type == 1)
                    @include('admin.reports.partials.waste', $report)

                @else
                    @include('admin.reports.partials.water', $report)
                @endif

                <div class="col-md-6">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20 clickable">
                        <h5>{{ $report->sensor->name }}</h5>

                        {!! $report->createChart() !!}
                    </div>
                </div>

            @endforeach

        </div>
    @endif

@endsection

@section('scripts')
    @parent
    
    <script>
        document.getElementsByTagName('form')[0].onsubmit = function(e){
            var date = document.getElementById('datePicker').value;
            e.target.setAttribute('action', e.target.getAttribute('action').replace('%date%', date));
        };
    </script>
@endsection
