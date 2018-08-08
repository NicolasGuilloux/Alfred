<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use App\Http\helpers;

class Sensor extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'driverName', 'driver', 'parent_id', 'place',
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null) {
        $commun = [
            'name'       => 'required',
            'driverName' => 'required',
            'parent_id'  => 'nullable',
            'place'      => 'required'
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'name'       => 'required',
            'driverName' => 'required',
            'parent_id'  => 'nullable',
            'place'      => 'required'
        ]);
    }

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */

    public function parent() {
        return $this->belongsTo('App\Sensor');
    }

    public function children() {
        return $this->hasMany('App\Sensor', 'parent_id', 'id');
    }

    public function reports() {
        return $this->hasMany('App\Report')->orderBy('date');
    }

    public function getDriverAttribute() {
        if( !isset($this->driverObject) )
            $this->driverObject = getDriver( $this->driverName );

        return $this->driverObject;
    }

    public function getTypeAttribute() {
        return $this->driver->type;
    }

    /*
    |------------------------------------------------------------------------------------
    | Methods
    |------------------------------------------------------------------------------------
    */

    public function getDataTree() {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'data' => ['href' => route(ADMIN . '.sensors.edit', $this->id)],
            'children' => []
        ];

        foreach( $this->children as $child ) {
            $array['children'][] = $child->getDataTree();
        }

        return $array;
    }

}
