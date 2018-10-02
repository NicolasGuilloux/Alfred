<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class DashboardController extends Controller
{

    /**
     * Loads the dashboard index view
     */
    public function index() {
        return view('admin.dashboard.index');
    }

    /**
     * Search the city in the AccuWeather API
     *
     * @param String Query
     *
     * @return JSON Array of cities
     */
    public function citySearch($query) {
        $url = 'http://dataservice.accuweather.com/locations/v1/cities/autocomplete?q=' . urlencode($query) . '&apikey=' . env('ACCUWHEATER_KEY');
        $json = json_decode(file_get_contents($url), true);

        return response()->json($json);
    }

}
