<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'association_id', 'role', 'desc'
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
     * The members that have opted for the option.
     */
    public function options()
    {
        return $this->belongsToMany('App\Option', 'have_opted');
    }

    /**
     * The user associated with this member.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The association associated with this member.
     */
    public function association()
    {
        return $this->belongsTo('App\Association');
    }
}
