<?php

declare(strict_types=1);

use App\Models\Language;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('authenticates user before creating a language', function (): void {
    $user = createUser();
    $response = post("/api/teams/{$user->currentTeam->id}/languages", [
        'name' => 'Language1',
        'data' => [
            'id' => 'lang1',
            'scopeName' => 'scope1',
            'grammar' => ['key' => 'value'],
            'aliases' => ['alias1', 'alias2'],
        ],
    ]);

    $response->assertRedirect('/login');
});

it('creates a new language', function (): void {
    $user = createUser();
    $languageData = [
        'name' => 'Language1',
        'data' => [
            'id' => 'lang1',
            'scopeName' => 'scope1',
            'grammar' => ['key' => 'value'],
            'aliases' => ['alias1', 'alias2'],
        ],
    ];

    $response = actingAs($user)->post("/api/teams/{$user->currentTeam->id}/languages", $languageData);

    $response->assertCreated();
    expect(Language::where('name', 'Language1')->firstOrFail()->toArray())->toMatchArray($languageData);
});

it('deletes an existing language', function (): void {
    $user = createUser();
    $language = Language::factory()->create([
        'name' => 'Language1',
        'team_id' => $user->current_team_id,
    ]);

    $response = actingAs($user)->delete("/api/teams/{$user->currentTeam->id}/languages/{$language->id}");

    $response->assertNoContent();
    expect(Language::find($language->id))->toBeNull();
});
