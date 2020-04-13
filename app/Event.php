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
        'title', 'begin', 'end', 'desc', 'location', 'link'
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
     * The materials that event requested.
     */
    public function materials()
    {
        return $this->belongsToMany('App\Material', 'rents');
    }

    /**
     * The rooms that event requested.
     */
    public function rooms()
    {
        return $this->belongsToMany('App\Room', 'occupations');
    }

    /**
     * The association associated with this event.
     */
    public function association()
    {
        return $this->belongsTo('App\Association');
    }
}
