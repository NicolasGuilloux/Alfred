<li class="nav-item mT-30 active">
    <a class='sidebar-link' href="{{ route('home') }}" default>
        <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Dashboard</span>
    </a>
</li>

<li class="nav-item mT-20">
    <a class='sidebar-link' href="{{ route('reports.index') }}">
        <span class="icon-holder">
            <i class="c-deep-orange-500 ti-bar-chart"></i>
        </span>
        <span class="title">Reports</span>
    </a>
</li>

<li class="nav-item">
    <a class='sidebar-link' href="{{ route('sensors.index') }}" default>
        <span class="icon-holder">
            <i class="c-purple-500 ti-signal"></i>
        </span>
        <span class="title">Sensors</span>
    </a>
</li>


<li class="nav-item mT-20">
    <a class='sidebar-link' href="{{ route('users.index') }}">
        <span class="icon-holder">
            <i class="c-teal-500 ti-user"></i>
        </span>
        <span class="title">Users</span>
    </a>
</li>

@if( Auth::user()->role > 9 )
    <li class="nav-item">
        <a class='sidebar-link' href="{{ route('market.index') }}">
            <span class="icon-holder">
                <i class="c-brown-500 ti-shopping-cart"></i>
            </span>
            <span class="title">Market</span>
        </a>
    </li>
@endif
