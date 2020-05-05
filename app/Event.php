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
        return $this->belongsToMany('App\Rents');
    }

    /**
     * The rooms that event requested.
     */
    public function rooms()
    {
        return $this->belongsToMany('App\Occupation');
    }

    /**
     * The association associated with this event.
     */
    public function association()
    {
        return $this->belongsTo('App\Association');
    }
}
