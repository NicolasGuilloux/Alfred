<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\DailyReport;
use App\Report;

class ReportController extends Controller
{

    /**
     * Display the default view
     */
    public function index() {
        $reports = Report::orderBy('date', 'desc')->get();

        $minDate = $reports->last()->date;
        $maxDate = $reports->first()->date;

        return view('admin.reports.index')
            ->with('minDate', $minDate)
            ->with('maxDate', $maxDate);
    }

    /**
     * Display the view with the selected date
     *
     * @param Date Date of the report
     */
    public function show($date) {
        $view = $this->index();

        $dailyReport = new DailyReport($date);

        return $view
            ->withDailyReport($dailyReport)
            ->withCurrentDate($date);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int     Sensor ID
     * @param  string  Date
     *
     * @return JSON    Chart
     */
    public function chart($id, $date) {
        $report = Report::where([
            ['date', '=', $date],
            ['sensor_id', '=', $id]
        ])->get();

        if( sizeof($report) >0 )
            return response()->json( $report[0]->chart );

        return response()->json( [] );
    }
}
