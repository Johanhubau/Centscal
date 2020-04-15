<?php

namespace App\Policies;

use App\Association;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssociationPolicy
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
     * @param  \App\Association  $association
     * @return mixed
     */
    public function view(User $user, Association $association)
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
     * @param  \App\Association  $association
     * @return mixed
     */
    public function update(User $user, Association $association)
    {
        if($user != null){
            return ($user->id == $association->president_id || $user->role == 'ROLE_ADMIN');
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Association  $association
     * @return mixed
     */
    public function delete(User $user, Association $association)
    {
        if($user != null){
            return ($user->id == $association->president_id || $user->role == 'ROLE_ADMIN');
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Association  $association
     * @return mixed
     */
    public function restore(User $user, Association $association)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Association  $association
     * @return mixed
     */
    public function forceDelete(User $user, Association $association)
    {
        //
    }
}
