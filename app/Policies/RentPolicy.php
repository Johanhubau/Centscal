<?php

namespace App\Policies;

use App\Association;
use App\Event;
use App\Material;
use App\Rent;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RentPolicy
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
     * @param  \App\Rent  $rent
     * @return mixed
     */
    public function view(User $user, Rent $rent)
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
     * @param  \App\Rent  $rent
     * @return mixed
     */
    public function update(User $user, Rent $rent)
    {
        if($user != null){
            return ($user->role == "ROLE_ADMIN" || $user->id == $rent->material->association->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rent  $rent
     * @return mixed
     */
    public function delete(User $user, Rent $rent)
    {
        if($user != null){
            return ($user->role == "ROLE_ADMIN" || $user->id == $rent->event->association->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rent  $rent
     * @return mixed
     */
    public function restore(User $user, Rent $rent)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rent  $rent
     * @return mixed
     */
    public function forceDelete(User $user, Rent $rent)
    {
        //
    }
}
