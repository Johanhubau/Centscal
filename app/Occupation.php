<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'approved', 'room_id', 'event_id'
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
     * The event that requested the rooms.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    /**
     * The room that has been requested.
     */
    public function room()
    {
        return $this->belongsTo('App\Room');
    }
}
