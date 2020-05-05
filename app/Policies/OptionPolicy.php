<?php

namespace App\Policies;

use App\Association;
use App\Option;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Option  $option
     * @return mixed
     */
    public function view(User $user, Option $option)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Option  $option
     * @return mixed
     */
    public function update(User $user, Option $option)
    {
        if($user != null){
            return ($user->role == "ROLE_ADMIN" || $user->id == $option->association()->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Option  $option
     * @return mixed
     */
    public function delete(User $user, Option $option)
    {
        if($user != null){
            return ($user->role == "ROLE_ADMIN" || $user->id == $option->association()->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Option  $option
     * @return mixed
     */
    public function restore(User $user, Option $option)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Option  $option
     * @return mixed
     */
    public function forceDelete(User $user, Option $option)
    {
        //
    }
}
