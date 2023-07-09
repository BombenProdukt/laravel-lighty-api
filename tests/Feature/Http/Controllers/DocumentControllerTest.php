<?php

declare(strict_types=1);

use App\Models\Document;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('authenticates user before creating a document', function (): void {
    $user = createUser();
    $response = post("/api/teams/{$user->currentTeam->id}/documents", [
        'body' => 'Hello World',
        'language' => 'php',
        'theme' => 'dark',
    ]);

    $response->assertRedirect('/login');
});

it('creates a new document', function (): void {
    $user = createUser();
    $language = $user->currentTeam->languages()->first();
    $theme = $user->currentTeam->themes()->first();
    $documentData = [
        'body' => \base64_encode('Hello World'),
        'language' => $language->name,
        'theme' => $theme->name,
    ];

    $response = actingAs($user)->post("/api/teams/{$user->currentTeam->id}/documents", $documentData);

    $response->assertCreated();
    expect(Document::first()->body)->toBe($documentData['body']);
    expect(Document::first()->language->name)->toBe($documentData['language']);
    expect(Document::first()->theme->name)->toBe($documentData['theme']);
});

it('deletes an existing document', function (): void {
    $user = createUser();
    $document = Document::factory()->create(['team_id' => $user->current_team_id]);

    $response = actingAs($user)->delete("/api/teams/{$user->currentTeam->id}/documents/{$document->id}");

    $response->assertNoContent();
    expect(Document::find($document->id))->toBeNull();
});
