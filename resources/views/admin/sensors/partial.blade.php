<li>
    <a href="{{ $item['data']['href'] }}">{{ $item['name'] }}</a>

    @foreach( $item['children'] as $item )
        <ul>
            @include('admin.sensors.partial', $item)
        </ul>
    @endforeach
</li>
