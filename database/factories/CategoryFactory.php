<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'parent_id' => null,
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'icon' => null,
            'position' => 0,
            'meta_title' => null,
            'meta_description' => null,
        ];
    }

    public function childOf(Category $parent): self
    {
        return $this->state(['parent_id' => $parent->id]);
    }
}
