<?php

namespace App;

use App\Report;

class DailyReport
{
    /**
     * Variables
     */
    protected $date = "aaaa-mm-jj";
    protected $data = array();

    public $reports = [];
    public $score   = 0;

    /**
    * Constructor
    *
    * @param String Date (aaaa-mm-jj)
    */
    public function __construct($date) {
        $this->date     = $date;
        $this->reports  = Report::where('date', '=', $date)->get();

        # Init data for each type of sensors
        foreach( config('variables.sensorType') as $key => $type ) {
            $this->data[] = [
                'type'      => $key,
                'typeStr'   => $type,
                'total'     => 0,
                'average'   => 0
            ];
        }

        # Looking for the root sensors (without parent)
        foreach($this->reports as $report) {
            if( is_null($report->sensor->parent_id) ) {
                $this->data[$report->type]['total'] += $report->total;
                $this->data[$report->type]['average'] += $report->average;
            }
        }

        # Calculate the score
        foreach( $this->data as $item ) {
            $this->score += $item['total'];
        }
        $this->score = (int) round( $this->score/100 );
    }

    /**
     * Provide data about the daily report to build a chart
     *
     * @param Int Type of the wanted report (e.g: 0 for Electricity)
     */
    public function chartReport($type) {
        $array = [
            'title' => config('variables.sensorType')[$type],
            'chart' => [
                'color' => config('variables.typeColor')[$type],
                'values' => [0, 0, 0]
            ],
            'number' => [
                'color' => 'green',
                'value' => $this->data[$type]['total'],
                'unit'  => config('variables.sensorUnit')[$type]
            ]
        ];

        return $array;
    }
}
