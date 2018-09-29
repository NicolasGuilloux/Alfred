<div class='col-md'>
    <div class="layers bd bgc-white p-20">
        <div class="layer w-100 mB-10">

            <!-- Title -->
            <h6 class="lh-1">
                {{ $title }}
            </h6>
        </div>
        <div class="layer w-100">
            <div class="peers ai-sb fxw-nw">
                <div class="peer peer-greed">

                    <!-- Chart -->
                    <span id="sparklinedash"></span>
                </div>
                <div class="peer">

                    <!-- Number -->
                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-{{ $number['color'] }}-50 c-{{ $number['color'] }}-500">
                        {{ number_format((float) $number['value'], 2, '.', '') }} {{ $number['unit'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
