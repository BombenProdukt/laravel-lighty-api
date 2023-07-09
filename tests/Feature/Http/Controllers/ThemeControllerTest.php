<?php

declare(strict_types=1);

use App\Models\Theme;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('authenticates user before creating a theme', function (): void {
    $user = createUser();
    $response = post("/api/teams/{$user->currentTeam->id}/themes", [
        'name' => 'Theme1',
        'data' => ['key' => 'value'],
    ]);

    $response->assertRedirect('/login');
});

it('creates a new theme', function (): void {
    $user = createUser();
    $themeData = [
        'name' => 'Theme1',
        'data' => ['key' => 'value'],
    ];

    $response = actingAs($user)->post("/api/teams/{$user->currentTeam->id}/themes", $themeData);

    $response->assertCreated();
    expect(Theme::where('name', 'Theme1')->firstOrFail()->toArray())->toMatchArray($themeData);
});

it('deletes an existing theme', function (): void {
    $user = createUser();
    $theme = Theme::factory()->create(['team_id' => $user->current_team_id]);

    $response = actingAs($user)->delete("/api/teams/{$user->currentTeam->id}/themes/{$theme->id}");

    $response->assertNoContent();
    expect(Theme::find($theme->id))->toBeNull();
});
