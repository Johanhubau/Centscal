<?php

namespace App\Policies;

use App\Association;
use App\Material;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
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
     * @param  \App\Material  $material
     * @return mixed
     */
    public function view(User $user, Material $material)
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
     * @param  \App\Material  $material
     * @return mixed
     */
    public function update(User $user, Material $material)
    {
        if($user != null){
            return ($user->role == 'ROLE_ADMIN' || $user->id == Association::find($material->association)->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function delete(User $user, Material $material)
    {
        if($user != null){
            return ($user->role == 'ROLE_ADMIN' || $user->id == Association::find($material->association)->president_id);
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function restore(User $user, Material $material)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function forceDelete(User $user, Material $material)
    {
        //
    }
}
