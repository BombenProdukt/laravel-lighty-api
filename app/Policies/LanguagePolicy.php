<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Language;
use App\Models\User;

final class LanguagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('languages:browse');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Language $language): bool
    {
        return $user->tokenCan('languages:read') && $language->team->hasUser($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('languages:write');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Language $language): bool
    {
        return $user->tokenCan('languages:update') && $language->team->hasUser($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Language $language): bool
    {
        return $user->tokenCan('languages:delete') && $language->team->hasUser($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Language $language): bool
    {
        return $user->tokenCan('languages:delete') && $language->team->hasUser($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Language $language): bool
    {
        return $user->tokenCan('languages:delete') && $language->team->hasUser($user);
    }
}
