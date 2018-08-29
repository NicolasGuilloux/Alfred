<?php

use App\Driver;

class Waste extends Driver {

    function build() {
        $this->name     = "Waste sensor";
        $this->version  = "1.0.0";
        $this->desc     = "An example of waste sensor";

        // 0: Electricity, 1: Waste, 2: Water
        $this->type     = 1;

        // Can't be removed
        $this->protected = true;
    }

    /**
     * Formats the data to be stored
     * The input data is in g. Change it to kg.
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
