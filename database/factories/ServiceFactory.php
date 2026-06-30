<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'custom_fields' => null,
            'is_active' => true,
            'position' => 0,
        ];
    }

    public function inCategory(Category $category): self
    {
        return $this->state(['category_id' => $category->id]);
    }

    public function inactive(): self
    {
        return $this->state(['is_active' => false]);
    }
}
