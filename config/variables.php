<?php

return [

    'boolean' => [
        '0' => 'No',
        '1' => 'Yes',
    ],

    'role' => [
        '0' => 'User',
        '10' => 'Admin',
    ],

    'status' => [
        '1' => 'Active',
        '0' => 'Inactive',
    ],

    'avatar' => [
        'public' => '/storage/avatar/',
        'folder' => 'avatar',

        'width'  => 400,
        'height' => 400,
    ],

    /** Sensors data **/

    'sensorType' => [
        '0' => 'Electricity',
        '1' => 'Waste',
        '2' => 'Water'
    ],

    'sensorUnit' => [
        '0' => 'kWH',
        '1' => 'kg',
        '2' => 'L'
    ],

    'typeColor' => [
        '0' => 'purple',
        '1' => 'red',
        '2' => 'blue'
    ],

    /*
    |------------------------------------------------------------------------------------
    | ENV of APP
    |------------------------------------------------------------------------------------
    */
    'APP_ADMIN' => 'admin',
    'APP_TOKEN' => env('APP_TOKEN', 'admin123456'),
];
