<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

final class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions([
            'documents:browse',
            'documents:create',
            'documents:read',
            'languages:browse',
            'languages:create',
            'languages:read',
            'themes:browse',
            'themes:create',
            'themes:read',
        ]);

        Jetstream::role('admin', 'Administrator', [
            'documents:browse',
            'documents:create',
            'documents:delete',
            'documents:read',
            'languages:browse',
            'languages:create',
            'languages:delete',
            'languages:read',
            'themes:browse',
            'themes:create',
            'themes:delete',
            'themes:read',
        ])->description('Administrator users can perform any action.');

        Jetstream::role('editor', 'Editor', [
            'documents:browse',
            'documents:create',
            'documents:read',
            'languages:browse',
            'languages:create',
            'languages:read',
            'themes:browse',
            'themes:create',
            'themes:read',
        ])->description('Editor users have the ability to browse, create and read.');
    }
}
