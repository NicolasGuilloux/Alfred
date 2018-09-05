<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\City;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'bio', 'role', 'city_id', 'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null) {
        $commun = [
            'email'    => "required|email|unique:users,email,$id",
            'password' => 'nullable|confirmed',
            'avatar' => 'image',
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value='') {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setAccuweatherIdAttribute($value='') {

        if( $value == '' )
            return;

        $city = City::where('accuweather_id', '=', $value)->get();

        if( sizeof($city) < 1 ) {
            $city = new City;
            $city->accuweather_id = $value;
            $city->save();
        }

        // Save the city ID
        $this->city_id = $city->first()->id;
        $this->save();
    }

    public function setAvatarAttribute($photo) {
        $this->attributes['avatar'] = move_file($photo, 'avatar');
    }

    public function getAgeAttribute($value) {
        return (int) floor((time() - strtotime($this->birthday)) / 31556926);
    }

    public function getAvatarAttribute($value) {
        if (!$value) {
            return asset('images/default-avatar.jpg');
        }

        return config('variables.avatar.public').$value;
    }

    /*
    |------------------------------------------------------------------------------------
    | Boot
    |------------------------------------------------------------------------------------
    */
    public static function boot() {
        parent::boot();
        static::updating(function($user)
        {
            $original = $user->getOriginal();

            if (\Hash::check('', $user->password)) {
                $user->attributes['password'] = $original['password'];
            }
        });
    }
}
