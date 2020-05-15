<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'begin', 'end', 'desc', 'location', 'link', 'association_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'begin' => 'datetime',
        'end' => 'datetime',
    ];

    /**
     * The rents that event requested.
     */
    public function rents()
    {
        return $this->hasMany('App\Rent');
    }

    /**
     * The occupations that event requested.
     */
    public function occupation()
    {
        return $this->hasOne('App\Occupation');
    }

    /**
     * The rooms that event requested.
     */
    public function rooms()
    {
        return $this->hasMany('App\Occupation');
    }

    /**
     * The association associated with this event.
     */
    public function association()
    {
        return $this->belongsTo('App\Association');
    }

    /**
     * The materials requested by the event
     */
    public function materials()
    {
        return $this->belongsToMany('App\Material', 'rents', 'event_id', 'material_id');
    }

    /**
     * The room requested by the event
     */
    public function room()
    {
        return $this->belongsToMany('App\Room', 'occupations', 'event_id', 'room_id');
    }
}
