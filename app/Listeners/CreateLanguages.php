<?php

declare(strict_types=1);

namespace App\Listeners;

use BombenProdukt\Lighty\Extension\GrammarFinder;
use BombenProdukt\Lighty\Shiki\ListLanguages;
use Laravel\Jetstream\Events\TeamCreated;

final class CreateLanguages
{
    public function handle(TeamCreated $event): void
    {
        foreach (ListLanguages::execute() as $name) {
            $event->team->languages()->create([
                'name' => $name,
            ]);
        }

        foreach (GrammarFinder::make()->all() as $name => $data) {
            $event->team->languages()->create([
                'name' => $name,
                'data' => $data,
            ]);
        }
    }
}
