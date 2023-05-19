<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobOffer;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobOfferPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isset($user->company);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JobOffer $job_offer)
    {
        return $user->id === $job_offer->company->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, JobOffer $job_offer)
    {
        return $user->id === $job_offer->company->user_id;
    }
}
