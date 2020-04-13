<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'association_id',
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
     * The options opted by the member.
     */
    public function members()
    {
        return $this->belongsToMany('App\Member', 'have_opted');
    }

    /**
     * The association that has this option.
     */
    public function association()
    {
        return $this->belongsTo('App\Association');
    }

}
