<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

use App\Sensor;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sensors = Sensor::where('parent_id', '=', null)->get();

        $items = array([], [], []);
        foreach( $sensors as $sensor )
            $items[$sensor->type][] = $sensor->getDataTree();

        $driversList = Storage::files('drivers/');
        $drivers = array();

        foreach( $driversList as $driver ) {
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', str_replace('drivers/', '', $driver) );
            $drivers[$name] = $name;
        }

        return view('admin.sensors.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sensorsTable = array(0 => 'Select the parent');
        foreach(Sensor::all() as $sensor)
            $sensorsTable[$sensor->id] = $sensor->name;

        return view('admin.sensors.create')
            ->with('sensorsTable', $sensorsTable)
            ->withDrivers($drivers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Sensor::rules());

        Sensor::create($request->all());

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Sensor::findOrFail($id);

        $sensorsTable = array(0 => 'Select the parent');
        foreach(Sensor::all() as $sensor)
            $sensorsTable[$sensor->id] = $sensor->name;

        $driversList = Storage::files('drivers/');
        $drivers = array();

        foreach( $driversList as $driver ) {
            $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', str_replace('drivers/', '', $driver) );
            $drivers[$name] = $name;
        }

        return view('admin.sensors.edit', compact('item'))
            ->with('sensorsTable', $sensorsTable)
                ->withDrivers($drivers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Sensor::rules(true, $id));

        $item = Sensor::findOrFail($id);

        $item->update($request->all());

        return redirect()->route(ADMIN . '.sensors.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sensor::destroy($id);

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
