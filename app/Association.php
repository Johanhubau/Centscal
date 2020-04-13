<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'color', 'president_id',
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
     * The president of the association.
     */
    public function president()
    {
        return $this->belongsTo('App\User', 'id', 'president_id');
    }

    /**
     * The members of the association.
     */
    public function members()
    {
        return $this->hasMany('App\Member');
    }

    /**
     * The rooms of the association.
     */
    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    /**
     * The options of the association.
     */
    public function options()
    {
        return $this->hasMany('App\Option');
    }

    /**
     * The events of the association.
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }

    /**
     * The materials of the association.
     */
    public function materials()
    {
        return $this->hasMany('App\Material');
    }
}
