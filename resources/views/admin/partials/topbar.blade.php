<div class="header navbar">
    <div class="header-container">
        <ul class="nav-left">
            <li>
                <a id='sidebar-toggle' class="sidebar-toggle" href="javascript:void(0);">
                    <i class="ti-menu"></i>
                </a>
            </li>

            <li id="clock" class="p-20 font-weight-bold "></li>
        </ul>

        <!-- Notifications -->
        <ul class="nav-right">
            <li class="notifications dropdown">
                <span class="counter bgc-red">
                    2
                </span>
                <a href="" class="dropdown-toggle no-after" data-toggle="dropdown">
                    <i class="ti-bell"></i>
                </a>

                <ul class="dropdown-menu">
                    <li class="pX-20 pY-15 bdB">
                        <i class="ti-bell pR-10"></i>
                        <span class="fsz-sm fw-600 c-grey-900">Notifications</span>
                    </li>
                    <li>
                        <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                            <li>
                                <a href="" class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'>
                                    <div class="peer mR-15">
                                        <img class="w-3r bdrs-50p" src="/images/1.jpg" alt="">
                                    </div>
                                    <div class="peer peer-greed">
                                        <span>
                                            <span class="fw-500">John Doe</span>
                                            <span class="c-grey-600">liked your <span class="text-dark">post</span></span>
                                        </span>
                                        <p class="m-0">
                                            <small class="fsz-xs">5 mins ago</small>
                                        </p>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="" class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'>
                                    <div class="peer mR-15">
                                        <img class="w-3r bdrs-50p" src="/images/2.jpg" alt="">
                                    </div>
                                    <div class="peer peer-greed">
                                        <span>
                                            <span class="fw-500">Moo Doe</span>
                                            <span class="c-grey-600">liked your <span class="text-dark">cover image</span></span>
                                        </span>

                                        <p class="m-0">
                                            <small class="fsz-xs">7 mins ago</small>
                                        </p>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="pX-20 pY-15 ta-c bdT">
                        <span>
                            <a href="" class="c-grey-600 cH-blue fsz-sm td-n">View All Notifications <i class="ti-angle-right fsz-xs mL-10"></i></a>
                        </span>
                    </li>
                </ul>
            </li>

            <!-- User -->
            <li class="dropdown">
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                    <div class="peer mR-10">
                        <img class="w-2r bdrs-50p" src="{{ auth()->user()->avatar }}" alt="">
                    </div>
                    <div class="peer">
                        <span class="fsz-sm c-grey-900">{{ auth()->user()->name }}</span>
                    </div>
                </a>
                <ul class="dropdown-menu fsz-sm">
                    <li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-settings mR-10"></i>
                            <span>Setting</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route(ADMIN . '.users.edit', auth()->user()->id) }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-user mR-10"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="/logout" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-power-off mR-10"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

@section('scripts')
    @parent

    <script>
        function displayDate() {
            var date    = new Date();
            var hours   = date.getHours();
            var minutes = date.getMinutes();

            var day     = date.getUTCDate();
            var month   = date.toLocaleString('en-us', { month: "long" })
            var year    = date.getUTCFullYear();

            $('#clock').text(hours + ':' + minutes + ' - ' + month + ', ' + day + ' ' + year);
        }

        displayDate();
        setInterval(displayDate, 1000);
    </script>
@endsection
