<!DOCTYPE html>

<!--
    {{ env('APP_LONG_NAME') }}
    Designed by Nicolas Guilloux - https://nicolasguilloux.eu/

    University College Cork - MSc Interactive Media
    Student n°117221997

    Based on this work: https://github.com/kossa/laradminator
-->

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ env('APP_LONG_NAME') }}</title>

        <!-- Styles -->
        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css" />
        <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}" />

        @yield('head')
    </head>

    <body class="app">

        @include('admin.partials.spinner')

        <div>
            <!-- #Left Sidebar ==================== -->
            @include('admin.partials.sidebar')

            <!-- #Main ============================ -->
            <div class="page-container">
                <!-- ### $Topbar ### -->
                @include('admin.partials.topbar')

                <!-- ### $App Screen Content ### -->
                <main class='main-content bgc-grey-100'>
                    <div id='mainContent'>
                        <div class="container-fluid">

                            <h4 class="c-grey-900 mT-10 mB-30">@yield('page-header')</h4>

                            @include('admin.partials.messages')
                            @yield('content')

                        </div>
                    </div>
                </main>

                <!-- ### $App Screen Footer ### -->
				<footer class="bdT ta-c p-30 fsz-sm c-grey-600">
					<span>Copyright © 2017-{{ date("Y") }} Designed by <a href="https://nicolasguilloux.eu" target='_blank' title="Nicolas Guilloux">Nicolas Guilloux</a> for the MSc Interactive Media project (UCC). All rights reserved.</span>
				</footer>
            </div>
        </div>

        <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <script src="{{ asset('/assets/js/app.js') }}"></script>
        <script src="{{ asset('/assets/js/main.js') }}"></script>

        @yield('scripts')

    </body>
</html>
