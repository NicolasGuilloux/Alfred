<?php

namespace App;

abstract class Driver {

    // Variables to set
    public $name, $version, $desc, $type;

    /* Abstract functions */
    abstract function formatData($data);
    abstract function build();


    // Variables
    public $typeName, $unit, $color;

    /**
     * Constructor
     */
    function __construct() {
        $this->build();

        $this->driverName = get_class($this);
        $this->typeName   = config('variables.sensorType')[$this->type];
        $this->unit       = config('variables.sensorUnit')[$this->type];
        $this->color      = config('variables.typeColor')[$this->type];
    }

    /**
     * When the program receives data
     */
    public function onReceive($data) {
        $formatedData = $this->formatData($data);
        var_dump($formatedData);
    }

    /**
     * Return the information of the addon
     */
    public function info() {
        return [
            "name"      => $this->name,
            "version"   => $this->version,
            "desc"      => $this->desc
        ];
    }
}
