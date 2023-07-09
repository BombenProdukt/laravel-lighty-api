<?php

declare(strict_types=1);

namespace App\Listeners;

use BombenProdukt\Lighty\Extension\ThemeFinder;
use BombenProdukt\Lighty\Shiki\ListThemes;
use Laravel\Jetstream\Events\TeamCreated;

final class CreateThemes
{
    public function handle(TeamCreated $event): void
    {
        foreach (ListThemes::execute() as $name) {
            $event->team->themes()->create([
                'name' => $name,
            ]);
        }

        foreach (ThemeFinder::make()->all() as $name => $data) {
            $event->team->themes()->create([
                'name' => $name,
                'data' => $data,
            ]);
        }
    }
}
