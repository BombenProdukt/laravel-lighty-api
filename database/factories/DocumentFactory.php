<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Language;
use App\Models\Team;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
final class DocumentFactory extends Factory
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
            'language_id' => Language::factory(),
            'theme_id' => Theme::factory(),
            'hash' => $this->faker->sha256,
            'body' => $this->faker->text,
            'html' => $this->faker->text,
        ];
    }
}
