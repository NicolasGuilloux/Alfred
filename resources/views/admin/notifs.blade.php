@extends('admin.default')

@section('page-header')
    Notifications
@endsection

@section('content')

<div class="row users text-center">
    @foreach ($notifications as $notif)
        <div class="col-md-4">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <p>
                    <img src="{!! $notif['img'] !!}" alt="Avatar" class="bdrs-50p p-3 w-50 " />
                </p>

                <h5>
                    {{ $notif['author']}}
                </h5>

                <p>
                    {{ date('D d M Y \a\t h:i a', $notif['date']) }}
                </p>

                <p>
                    {!! $notif['content'] !!}
                </p>
            </div>
        </div>
    @endforeach
</div>
@endsection
