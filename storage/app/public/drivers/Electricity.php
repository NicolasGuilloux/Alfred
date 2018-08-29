<?php

use App\Driver;

class Electricity extends Driver {

    function build() {
        $this->name     = "Electric sensor";
        $this->version  = "1.0.1";
        $this->desc     = "An example of electric sensor";

        // 0: Electricity, 1: Waste, 2: Water
        $this->type     = 0;

        // Can't be removed
        $this->protected = true;
    }

    /**
     * Formats the data to be stored
     * The input data is in W. Change it to KW.
     *
     * @param Array Data given by the sensor
     *
     * @param Array Formated data
     */
    function formatData($data) {
        $formatedData = array();

        foreach($data as $entry) {
            $formatedData[] = $entry / 1000;
        }

        return $formatedData;
    }
}
