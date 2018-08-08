<?php

if (! function_exists('move_file')) {
    function move_file($file, $type='avatar', $withWatermark = false)
    {
        // Grab all variables
        $destinationPath = config('variables.'.$type.'.folder');
        $width           = config('variables.' . $type . '.width');
        $height          = config('variables.' . $type . '.height');
        $full_name       = str_random(16) . '.' . $file->getClientOriginalExtension();

        if ($width == null && $height == null) { // Just move the file
            $file->storeAs($destinationPath, $full_name);
            return $full_name;
        }


        // Create the Image
        $image           = Image::make($file->getRealPath());

        if ($width == null || $height == null) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }else{
            $image->fit($width, $height);
        }

        if ($withWatermark) {
            $watermark = Image::make(public_path() . '/img/watermark.png')->resize($width * 0.5, null);

            $image->insert($watermark, 'center');
        }

        Storage::put($destinationPath . '/' . $full_name, (string) $image->encode());

        return $full_name;
    }
}

/**
 * Get the JSON of an URL
 *
 * @param String URL
 *
 * @return Array JSON transformed to a PHP array
 **/
if (! function_exists('getJSON')) {
    function getJSON($url) {
        return $marketDrivers = json_decode( file_get_contents($url), true );
    }
}

/**
 * Load a driver
 *
 * @param String Driver's name
 *
 * @return Driver
 */
if (! function_exists('getDriver')) {
    function getDriver($name) {
        include_once( storage_path('app/public/drivers/'. $name .'.php') );
        return new $name();
    }
}

/**
 * Get installed drivers list
 *
 * @return Array Drivers list
 **/
if (! function_exists('getDrivers')) {
    function getDrivers() {
        $driversList = Storage::files('drivers/');
        $drivers = array();

        foreach( $driversList as $driver ) {
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', str_replace('drivers/', '', $driver) );
            $drivers[] = getDriver($name);
        }

        return $drivers;
    }
}
