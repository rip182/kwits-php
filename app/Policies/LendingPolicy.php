<?php

namespace App\Policies;

use App\User;
use App\Lending;
use Illuminate\Auth\Access\HandlesAuthorization;

class LendingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the lending.
     *
     * @param  \App\User  $user
     * @param  \App\Lending  $lending
     * @return mixed
     */
    public function view(User $user, Lending $lending)
    {
        //
    }

    /**
     * Determine whether the user can create lendings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the lending.
     *
     * @param  \App\User  $user
     * @param  \App\Lending  $lending
     * @return mixed
     */
    public function update(User $user, Lending $lending)
    {
        //
    }

    /**
     * Determine whether the user can delete the lending.
     *
     * @param  \App\User  $user
     * @param  \App\Lending  $lending
     * @return mixed
     */
    public function delete(User $user, Lending $lending)
    {
        return $lending->user_id == $user->id;
    }
}
