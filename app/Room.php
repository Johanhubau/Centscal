<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location', 'owner_id',
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
     * The the bookings for the rooms.
     */
    public function occupations()
    {
        return $this->belongsToMany('App\Occupation');
    }

    /**
     * The association that owns the room.
     */
    public function association()
    {
        return $this->belongsTo('App\Association', 'owner_id', 'id');
    }
}
