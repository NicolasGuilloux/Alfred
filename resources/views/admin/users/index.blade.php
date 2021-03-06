@extends('admin.default')

@section('page-header')
    Users
@endsection

@section('content')

<div class="row users text-center">
    @foreach ($items as $item)
        <div class="col-md-3">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
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

                @if( Auth::user()->id == $item->id )
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route('users.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                        <li class="list-inline-item">
                            {!! Form::open([
                                'class'=>'delete',
                                'url'  => route('users.destroy', $item->id),
                                'method' => 'DELETE',
                                ])
                            !!}

                                <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>

                            {!! Form::close() !!}
                        </li>
                    </ul>
                @endif
                
            </div>
        </div>
    @endforeach
</div>
@endsection
