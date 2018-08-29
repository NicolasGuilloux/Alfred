<?php

use App\Driver;

class Water extends Driver {

    function build() {
        $this->name     = "Water sensor";
        $this->version  = "1.0.0";
        $this->desc     = "An example of water sensor";

        // 0: Electricity, 1: Waste, 2: Water
        $this->type     = 2;

        // Can't be removed
        $this->protected = true;
    }

    /**
     * Formats the data to be stored
     * The input data is in L. We do not change anything.
     *
     * @param Array Data given by the sensor
     *
     * @param Array Formated data
     */
    function formatData($data) {
        return $data;
    }
}
