<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'parent_id', 'place'
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null) {
        $commun = [
            'name'      => 'required',
            'type'      => 'required',
            'parent_id' => 'nullable',
            'place'     => 'required'
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'name'      => 'required',
            'type'      => 'required',
            'parent_id' => 'nullable',
            'place'     => 'required'
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
        return $this->hasMany('App\Report')->orderBy('date');;
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
