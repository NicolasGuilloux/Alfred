<div class="layers bd bgc-white p-20">
    <div class="layer w-100 mB-10">
        <h6 class="lh-1">Waste</h6>
    </div>
    <div class="layer w-100">
        <div class="peers ai-sb fxw-nw">
            <div class="peer peer-greed">
                <span id="sparklinedash4"></span>
            </div>
            <div class="peer">

                @if($percent > 0)
                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">+{{ $percent }}%</span>

                @elseif ($percent < 0)
                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ $percent }}%</span>

                @else
                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">{{ $percent }}%</span>
                @endif

            </div>
        </div>
    </div>
</div>
