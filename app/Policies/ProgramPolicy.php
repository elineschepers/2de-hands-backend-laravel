<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Program;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('programs.list');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Program $program
     * @return mixed
     */
    public function view(User $user, Program $program)
    {
        return $user->hasPermissionTo('programs.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('programs.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Program $program
     * @return mixed
     */
    public function update(User $user, Program $program)
    {
        return $user->hasPermissionTo('programs.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Program $program
     * @return mixed
     */
    public function delete(User $user, Program $program)
    {
        return $user->hasPermissionTo('programs.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Program $program
     * @return mixed
     */
    public function restore(User $user, Program $program)
    {
        return $user->hasPermissionTo('programs.delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Program $program
     * @return mixed
     */
    public function forceDelete(User $user, Program $program)
    {
        return $user->hasPermissionTo('programs.delete');
    }
}
