<!-- #Weather ==================== -->
<div class="bd bgc-white p-20">
    <div class="layers">
        <!-- Widget Title -->
        <div class="layer w-100 mB-20">
            <h6 class="lh-1">Weather in {{ $city->name }}</h6>
        </div>

        <!-- Today Weather -->
        <div class="layer w-100">
            <div class="peers ai-c jc-sb fxw-nw">
                <div class="peer peer-greed">
                    <div class="layers">

                        <!-- Temperature -->
                        <div class="layer w-100">
                            <div class="peers fxw-nw ai-c">
                                <div class="peer mR-20">
                                    <h3>{{ $city->forecast[0]['temperature'] }}<sup>°C</sup></h3>
                                </div>
                                <div class="peer">
                                    <canvas class="{{ $city->forecast[0]['icon'] }}" width="44" height="44"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Condition -->
                        <div class="layer w-100 pR-10">
                            <span class="fw-600 c-grey-600">{{ str_replace(';', ',', $city->forecast[0]['description']) }}</span>
                        </div>
                    </div>
                </div>
                <div class="peer">
                    <div class="layers ai-fe">
                        <div class="layer">
                            <h5 class="mB-5">{{ date('l', $city->forecast[0]['timestamp']) }}</h5>
                        </div>
                        <div class="layer">
                            <span class="fw-600 c-grey-600">{{ date('M, d Y', $city->forecast[0]['timestamp']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today Weather Extended -->
        <div class="layer w-100 mY-30">
            <div class="layers bdB">
                <div class="layer w-100 bdT pY-5">
                    <div class="peers ai-c jc-sb fxw-nw">
                        <div class="peer">
                            <span>Wind</span>
                        </div>
                        <div class="peer ta-r">
                            <span class="fw-600 c-grey-800">{{ $city->forecast[0]['wind'] }}km/h</span>
                        </div>
                    </div>
                </div>
                <div class="layer w-100 bdT pY-5">
                    <div class="peers ai-c jc-sb fxw-nw">
                        <div class="peer">
                            <span>Sun</span>
                        </div>
                        <div class="peer ta-r">
                            <span class="fw-600 c-grey-800">From {{ date('h:i A', $city->forecast[0]['sunrise_timestamp']) }} to {{ date('h:i A', $city->forecast[0]['sunset_timestamp']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Week Forecast -->
        <div class="layer w-100">
            <div class="peers peers-greed ai-fs ta-c">

                @foreach ($city->forecast as $forecast)
                    @if($loop->index != 0)

                        <div class="peer">
                            <h6 class="mB-10">{{ date('D', $city->forecast[$loop->index]['timestamp']) }}</h6>
                            <canvas class="{{ $city->forecast[$loop->index]['icon'] }}" width="30" height="30"></canvas>
                            <span class="d-b fw-600">{{ $city->forecast[$loop->index]['temperature'] }}<sup>°C</sup></span>
                        </div>

                    @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
