<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'title' => $title,
            'body' => fake()->paragraphs(3, true),
            'meta_title' => null,
            'meta_description' => null,
            'is_active' => true,
        ];
    }

    public function inactive(): self
    {
        return $this->state(['is_active' => false]);
    }
}
