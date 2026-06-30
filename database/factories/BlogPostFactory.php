<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'title' => $title,
            'excerpt' => fake()->paragraph(),
            'body' => fake()->paragraphs(5, true),
            'meta_title' => null,
            'meta_description' => null,
            'author_name' => fake()->name(),
            'tags' => null,
            'published_at' => now()->subDays(1),
            'is_active' => true,
        ];
    }

    public function draft(): self
    {
        return $this->state(['published_at' => null]);
    }

    public function scheduled(): self
    {
        return $this->state(['published_at' => now()->addWeek()]);
    }

    public function inactive(): self
    {
        return $this->state(['is_active' => false]);
    }
}
