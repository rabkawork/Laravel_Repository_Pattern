<?php

namespace App\Policies;

use App\Models\Kost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function detail(User $user)
    {
        return true;
    }




    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Kost $kost)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->permission == 1 ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Kost $kost)
    {
        return $user->id == $kost->user_id ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Kost $kost)
    {
        return $user->id == $kost->user_id ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Kost $kost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Kost $kost)
    {
        //
    }
}
