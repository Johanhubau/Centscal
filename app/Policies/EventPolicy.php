<?php

namespace App\Policies;

use App\Event;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
     * @param  \App\Event  $event
     * @return mixed
     */
    public function view(User $user, Event $event)
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

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function update(User $user, Event $event)
    {
        if($user != null){
            $association = $event->association;
            return $user->id == $association->president_id || $association->members->contains($user->memberships);
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function delete(User $user, Event $event)
    {
        if($user != null){
            $association = $event->association;
            return $user->id == $association->president_id || $association->members->contains($user->memberships);
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function restore(User $user, Event $event)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function forceDelete(User $user, Event $event)
    {
        //
    }
}
