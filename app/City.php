<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use Storage;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country', 'area', 'accuweather_id'
    ];


    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
    public function setAccuweatherIdAttribute($value='') {
        $this->attributes['accuweather_id'] = $value;

        $url = 'http://dataservice.accuweather.com/locations/v1/' . $this->accuweather_id . '?apikey=' . env('ACCUWHEATER_KEY');
        $data = json_decode(file_get_contents($url), true);

        $this->name = $data['LocalizedName'];
        $this->country = $data['Country']['LocalizedName'];
        $this->area = $data['AdministrativeArea']['LocalizedName'];
    }

    /**
     * Get the forecast from the file, or make an API request
     */
    public function getForecastAttribute() {

        $filename = 'weather/' . $this->accuweather_id . '.ser';

        // Create or load the weather.ser file where the weather is stored
        if( !Storage::exists($filename) )
            return $this->parseWeather()['forecast'];

        // Get the stored value and check it
        $weather = unserialize( Storage::get($filename) );

        // Update the data after 1h
        if( Carbon::now()->timestamp - $weather['query_date'] > 3600 )
            return $this->parseWeather()['forecast'];

        return $weather['forecast'];
    }

    /***** Private functions *****/

    /**
     * Get the weather from the AccuWeather API
     *
     * @param Integer Openweathermap City ID
     *
     * @return Array
     */
    private function parseWeather() {

        $weather = [
            'query_date' => Carbon::now()->timestamp,
            'forecast' => []
        ];

        // Get informations about the weather
        $url = 'https://dataservice.accuweather.com/forecasts/v1/daily/5day/' . $this->accuweather_id . '?apikey=' . env('ACCUWHEATER_KEY') . '&details=true&metric=true';
        $json = json_decode(file_get_contents($url), true);

        foreach($json['DailyForecasts'] as $dailyForecast) {
            $day = [
                'date' => $dailyForecast['Date'],
                'timestamp' => $dailyForecast['EpochDate'],

                'description' => $dailyForecast['Day']['LongPhrase'],
                'icon' => $this->getIconName( $dailyForecast['Day']['Icon'] ),

                'temperature' => round( ($dailyForecast['Temperature']['Minimum']['Value'] + $dailyForecast['Temperature']['Maximum']['Value'])/2, 1),
                'wind' => $dailyForecast['Day']['Wind']['Speed']['Value'],

                'sunrise_timestamp' => $dailyForecast['Sun']['EpochRise'],
                'sunset_timestamp' => $dailyForecast['Sun']['EpochSet'],
            ];
            $weather['forecast'][] = $day;
        }

        Storage::put('weather/' . $this->accuweather_id . '.ser', serialize($weather));

        return $weather;
    }

    /**
     * Translate the AccuWeather icon name with the framework icon name
     *
     * @param Integer Value of the AccuWeather icon identifier
     *
     * @return String Framework icon name
     */
    private function getIconName($id) {

        // Windy
        if($id == 32 || ($id >= 19 && $id <= 21))
            return "wind";

        // Sleet
        if($id == 25)
            return "sleet";

        // Snow
        if(($id >= 22 && $id <= 24) || $id == 26 || $id == 29)
            return "snow";

        // Fog
        if($id == 11)
            return "fog";

        // Rain
        if($id >= 12  && $id <= 18)
            return "rain";

        // Partly Cloudy
        if($id >= 4 && $id <= 6)
            return "partly-cloudy-day";

        // Cloudy
        if($id >= 7 && $id <= 8)
            return "cloudy";

        return "clear-day";
    }
}
