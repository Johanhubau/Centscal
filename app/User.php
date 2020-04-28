<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'ldap', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The associations for which the user is a president.
     */
    public function president_associations()
    {
        return $this->hasMany('App\Association', 'president_id');
    }

    /**
     * The memberships of the user.
     */
    public function memberships()
    {
        return $this->hasMany('App\Member');
    }

    /**
     * Check whether the user is admin or not
     */
    public function isAdmin() {
        return $this->role == 'ROLE_ADMIN';
    }
}
