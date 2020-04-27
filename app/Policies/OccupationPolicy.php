<?php

namespace App\Policies;

use App\Association;
use App\Event;
use App\Occupation;
use App\Room;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OccupationPolicy
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
     * @param  \App\Occupation  $occupation
     * @return mixed
     */
    public function view(User $user, Occupation $occupation)
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
     * @param  \App\Occupation  $occupation
     * @return mixed
     */
    public function update(User $user, Occupation $occupation)
    {
        if($user != null){
            return ($user->role == 'ROLE_ADMIN' || $user->id == Association::find(Room::find($occupation->room_id)->owner_id)->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Occupation  $occupation
     * @return mixed
     */
    public function delete(User $user, Occupation $occupation)
    {
        if($user != null){
            return ($user->role == 'ROLE_ADMIN' || $user->id == Association::find(Event::find($occupation->event_id)->association_id)->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Occupation  $occupation
     * @return mixed
     */
    public function restore(User $user, Occupation $occupation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Occupation  $occupation
     * @return mixed
     */
    public function forceDelete(User $user, Occupation $occupation)
    {
        //
    }
}
