@extends('admin.default')

@section('page-header')
    Market
@endsection

@section('content')
    <h2>Installed addons</h2>

    <div class="row text-center">

        @foreach($localDrivers as $driver)

            <div class="col-md-3">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h3>{{ $driver->driverName }}</h3>

                    <p class="mB-20">
                        <strong>{{ $driver->version }}</strong>
                    </p>

                    <p class="mB-20">
                        {{ $driver->desc }}
                    </p>

                    <ul class="list-inline">

                        @if( isset($driver->newVersion) )
                            <li class="list-inline-item">
                                <a href="{!! route('market.save', $driver->driverName) !!}" title="Update the addon to the version {{ $driver->newVersion }}" class="btn btn-success btn-sm"><span class="ti-reload"></span></a>
                            </li>
                        @endif

                        @if( !isset($driver->protected) || !$driver->protected )
                            <li class="list-inline-item">
                                <a href="{!! route('market.delete', $driver->driverName) !!}" title="Delete the addon" class="btn btn-danger btn-sm"><span class="ti-trash"></span></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        @endforeach
    </div>

    <h2>Available addons</h2>

    <div class="row text-center">
        @foreach($marketDrivers as $driver)

            <div class="col-md-3">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h3>{{ $driver['driverName'] }}</h3>

                    <p class="mB-20">
                        <strong>{{ $driver['version'] }}</strong>
                    </p>

                    <p class="mB-20">
                        {{ $driver['desc'] }}
                    </p>

                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{!! route('market.save', $driver['driverName']) !!}" title="Install the addon" class="btn btn-primary btn-sm"><span class="ti-import"></span></a>
                        </li>
                    </ul>
                </div>
            </div>

        @endforeach
    </div>
@endsection
