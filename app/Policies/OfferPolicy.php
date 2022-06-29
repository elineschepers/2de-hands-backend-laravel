<?php

namespace App\Policies;

use App\Models\Offer;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class OfferPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('offers.list');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function view(User $user, Offer $offer)
    {
        return ($user->id === $offer->user_id) || $user->hasPermissionTo('offers.show') ;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('offers.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function update(User $user, Offer $offer)
    {
        return $user->id === $offer->user_id || $user->hasPermissionTo('offers.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function delete(User $user, Offer $offer)
    {
        return ($user->id === $offer->user_id) || $user->hasPermissionTo('offers.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function restore(User $user, Offer $offer)
    {
        return $user->hasPermissionTo('offers.delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function forceDelete(User $user, Offer $offer)
    {
        return $user->hasPermissionTo('offers.delete');
    }
}
