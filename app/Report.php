<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sensor_id', 'startDate', 'endDate', 'interval',
        'average', 'min', 'max', 'total',
        'data'
    ];

    protected $chart = [
        "type" => "line",
        "data" => [
            "labels" => [
                "12am", "1am", "2am", "3am", "4am", "5am", "6am", "7am", "8am", "9am", "10am", "11am",
                "12pm", "1pm", "2pm", "3pm", "4pm", "5pm", "6pm", "7pm", "8pm", "9pm", "10pm", "11pm"
            ],
            "datasets" => [
                [
                    "label" => "",
                    "data" => [],

                    "borderWidth" => 1,
                    "backgroundColor" => "rgba(255, 0, 0, 0.1)",
                    "borderColor" => "rgba(255, 0, 0, 1)"
                ]
            ]
        ],

        "options" => [
            "elements" => [
                "point" => [
                    // If there are to much points
                    "radius" => 0
                ]
            ],

            "legend" => [
                "display" => false
            ],

            "scales" => [
                "yAxes" => [
                    [
                        "ticks" => [
                            "beginAtZero" => true
                        ],
                        "scaleLabel" => [
                            "display" => true,
                            "labelString" => "yLabel"
                        ]
                    ]
                ],
            ]
        ]
    ];

    /**
     * Link to the sensor
     */
    public function sensor() {
        return $this->belongsTo('App\Sensor');
    }

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null) {
        $commun = [
            'sensor_id'      => 'required',
            'startDate'      => 'required',
            'endDate'        => 'required',
            'interval'       => 'required',
            'data'           => 'required'
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'sensor_id'      => 'required',
            'startDate'      => 'required',
            'endDate'        => 'required',
            'interval'       => 'required',
            'data'           => 'required'
        ]);
    }

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
    public function getTypeAttribute() {
        return $this->sensor->type;
    }

    public function getUnitAttribute() {
        return config('variables.sensorUnit')[$this->type];
    }


    public function getDataAttribute($value) {
        return json_decode($value);
    }

    public function getTotalAttribute() {
        $data = $this->data;
        $length = sizeof($data);

        return array_sum($data) * 24 / $length;
    }

    public function getMaxAttribute() {
        return max($this->data);
    }

    public function getMinAttribute() {
        return min($this->data);
    }

    public function getAverageAttribute() {
        $total  = $this->total;
        $length = sizeof($this->data);

        return $total/$length;
    }

    public function getChartAttribute() {

        # Electricity
        if( $this->type == 0 ) {
            # #9c27b0
            $this->chart['data']['datasets'][0]['backgroundColor'] = "rgba(61, 15, 69, 0.1)";
            $this->chart['data']['datasets'][0]['borderColor'] = "rgba(61, 15, 69, 1)";

        # Waste
        } else if( $this->type == 1 ) {
            # #f44336
            $this->chart['data']['datasets'][0]['backgroundColor'] = "rgba(96, 26, 21, 0.1)";
            $this->chart['data']['datasets'][0]['borderColor'] = "rgba(96, 26, 21, 1)";

        # Water
        } else {
            # #2196f3
            $this->chart['data']['datasets'][0]['backgroundColor'] = "rgba(13, 59, 95, 0.1)";
            $this->chart['data']['datasets'][0]['borderColor'] = "rgba(13, 59, 95, 1)";
        }

        $this->chart['options']['scales']['yAxes'][0]['scaleLabel']['labelString'] = $this->unit;

        $data = $this->data;
        $labels = [];

        $startTime = strtotime($this->date);
        $sampleLength = 86400 / sizeof($data);

        foreach($data as $key => $value) {
            $timestamp = $startTime + $key * $sampleLength;
            $labels[]  = date('h:i A', $timestamp);
        }

        $this->chart['data']['datasets'][0]['data'] = $data;
        $this->chart['data']['labels'] = $labels;

        return $this->chart;
    }

    /*
    |------------------------------------------------------------------------------------
    | Methods
    |------------------------------------------------------------------------------------
    */
    public function createChart() {
        $str = '<canvas id="' . $this->id . '"></canvas>';

        $str .= "
        <script>
            var ctx" . $this->id . " = document.getElementById('" . $this->id . "').getContext('2d');
            var options" . $this->id . " = " . json_encode( $this->getChartAttribute() ) . "
            var myChart" . $this->id . " = new Chart(ctx" . $this->id . ", options" . $this->id . ");
        </script>
        ";

        return $str;
    }
}
