<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use App\Http\helpers;

class MarketController extends Controller
{
    public function index() {
        /* Get local drivers */
        $localDrivers = getDrivers();

        /* Get market drivers */
        $marketDrivers = getJSON( env('APP_URL_SERVER') . '/api/drivers' );

        foreach($localDrivers as $driver) {
            $key = array_search($driver->driverName, array_column($marketDrivers, 'driverName'));

            // Check if there is an update
            if( version_compare($driver->version, $marketDrivers[$key]['version']) < 0 )
                $driver->newVersion = $marketDrivers[$key]['version'];

            unset($marketDrivers[$key]);
            $marketDrivers = array_values($marketDrivers);
        }

        // Return the view
        return view('admin.market.index')
            ->with('localDrivers', $localDrivers)
            ->with('marketDrivers', $marketDrivers);
    }

    /**
     * Update the driver
     *
     * @param String Name of the driver
     */
    public function save($name) {
        $url = env('APP_URL_SERVER') . '/api/drivers/source/' . $name;
        $source = file_get_contents($url);

        Storage::put('drivers/' . $name . '.php', $source);

        return redirect( route('admin.market.index') );
    }

    /**
     * Delete a driver
     *
     * @param String Name of the driver
     */
    public function delete($name) {
        $driver = getDriver($name);

        if( !isset($driver->protected) || !$driver->protected)
            Storage::delete('drivers/' . $name . '.php');

        return redirect( route('admin.market.index') );
    }
}
