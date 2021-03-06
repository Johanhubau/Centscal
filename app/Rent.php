<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'approved', 'event_id', 'material_id'
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
    ];

    /**
     * The event that requested the material.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    /**
     * The material rented.
     */
    public function material()
    {
        return $this->belongsTo('App\Material');
    }
}
