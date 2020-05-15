<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'desc', 'price', 'association_id'
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
     * The rents for that material.
     */
    public function rents()
    {
        return $this->hasMany('App\Rent');
    }

    /**
     * The association associated with this material.
     */
    public function association()
    {
        return $this->belongsTo('App\Association');
    }
}
