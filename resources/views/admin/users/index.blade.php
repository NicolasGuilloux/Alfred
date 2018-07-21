@extends('admin.default')

@section('page-header')
    Users <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

<div class="mB-20">
    <a href="{{ route(ADMIN . '.users.create') }}" class="btn btn-info">
        {{ trans('app.add_button') }}
    </a>
</div>

<div class="row users text-center">
    @foreach ($items as $item)
        <div class="col-md-3">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <a href="{{ route(ADMIN . '.users.edit', $item->id) }}">
                    <img src="{{ $item->avatar }}" alt="Avatar" class="bdrs-50p w-100 mB-10" />
                    <p class="mB-20">
                        <strong>{{ $item->name }}</strong>
                    </p>

                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route(ADMIN . '.users.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                        <li class="list-inline-item">
                            {!! Form::open([
                                'class'=>'delete',
                                'url'  => route(ADMIN . '.users.destroy', $item->id),
                                'method' => 'DELETE',
                                ])
                            !!}

                                <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>

                            {!! Form::close() !!}
                        </li>
                    </ul>
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
