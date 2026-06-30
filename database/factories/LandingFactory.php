<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\LandingStatus;
use App\Models\Category;
use App\Models\Landing;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Landing>
 */
class LandingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'location_id' => null,
            'slug' => null,
            'title' => null,
            'meta_description' => null,
            'content' => null,
            'status' => LandingStatus::Published,
            'publish_at' => null,
        ];
    }

    public function forCategory(Category $category): self
    {
        return $this->state(['category_id' => $category->id]);
    }

    public function inLocation(Location $location): self
    {
        return $this->state(['location_id' => $location->id]);
    }

    public function draft(): self
    {
        return $this->state(['status' => LandingStatus::Draft, 'publish_at' => null]);
    }

    public function published(): self
    {
        return $this->state(['status' => LandingStatus::Published, 'publish_at' => null]);
    }

    public function scheduled(?Carbon $at = null): self
    {
        return $this->state([
            'status' => LandingStatus::Scheduled,
            'publish_at' => $at ?? now()->addDay(),
        ]);
    }
}
