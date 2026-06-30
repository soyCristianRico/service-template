<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\LocationType;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->city();

        return [
            'parent_id' => null,
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'type' => LocationType::City,
            'population' => fake()->numberBetween(10_000, 5_000_000),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'meta_title' => null,
            'meta_description' => null,
        ];
    }

    public function ofType(LocationType $type): self
    {
        return $this->state(['type' => $type]);
    }

    public function childOf(Location $parent): self
    {
        return $this->state(['parent_id' => $parent->id]);
    }
}
