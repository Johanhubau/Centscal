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
     * The events that requested the rooms.
     */
    public function events()
    {
        return $this->belongsToMany('App\Event', 'occupations');
    }

    /**
     * The association that owns the room.
     */
    public function association()
    {
        return $this->belongsTo('App\Association');
    }
}
