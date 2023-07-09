<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Theme;
use App\Models\User;

final class ThemePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('themes:browse');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Theme $theme): bool
    {
        return $user->tokenCan('themes:read') && $theme->team->hasUser($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('themes:write');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Theme $theme): bool
    {
        return $user->tokenCan('themes:update') && $theme->team->hasUser($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Theme $theme): bool
    {
        return $user->tokenCan('themes:delete') && $theme->team->hasUser($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Theme $theme): bool
    {
        return $user->tokenCan('themes:delete') && $theme->team->hasUser($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Theme $theme): bool
    {
        return $user->tokenCan('themes:delete') && $theme->team->hasUser($user);
    }
}
