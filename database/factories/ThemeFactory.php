<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Theme>
 */
final class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'name' => $this->faker->word,
            'data' => \json_decode(\file_get_contents(storage_path('lighty/themes/GitHub/github-vscode-theme/light-default.json')), true, 512, \JSON_THROW_ON_ERROR),
        ];
    }
}
