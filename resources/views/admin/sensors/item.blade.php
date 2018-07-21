<li>{{ $item->name }}
    <ul>
    @foreach ($item->children as $item)
        @include('admin.sensors.item', $item)
    @endforeach
    </ul>
</li>
