@extends('admin.default')

@section('page-header')
  User <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
    {!! Form::model($item, [
        'action' => ['UserController@update', $item->id],
        'method' => 'put',
        'files' => true
      ])
    !!}

    <div class="row mB-40">
        <div class="col-md-8">
            <div class="bgc-white p-20 bd">
                @include('admin.users.form')
            </div>
        </div>

        <div class="col-md-4">
            <div class="bgc-white p-20 bd text-center">
                <p>
                    <img src="{{ $item->avatar }}" alt="Avatar" class="bdrs-50p p-3 w-50 " />
                </p>

                <h5>
                    {{ $item->name }}
                </h5>

                <p>
                    {{ $item->age }} years old<br />
                    @if( isset($item->city) )
                        Live in {{ $item->city->name }}, {{ $item->city->country }}
                    @endif
                </p>

                <p>
                    <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                </p>

                <hr class="m-20" />

                <p>
                    {{ $item->bio }}
                </p>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>

  {!! Form::close() !!}

@stop
