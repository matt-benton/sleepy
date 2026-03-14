<?php

namespace App\Policies;

use App\Models\SleepEntry;
use App\Models\User;

class SleepEntryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SleepEntry $sleepEntry): bool
    {
        return $user->id === $sleepEntry->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SleepEntry $sleepEntry): bool
    {
        return $user->id === $sleepEntry->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SleepEntry $sleepEntry): bool
    {
        return $user->id === $sleepEntry->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SleepEntry $sleepEntry): bool
    {
        return $user->id === $sleepEntry->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SleepEntry $sleepEntry): bool
    {
        return false;
    }
}
