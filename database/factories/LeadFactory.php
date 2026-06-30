<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\LeadStatus;
use App\Models\Landing;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'landing_id' => null,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'message' => fake()->paragraph(),
            'source_url' => null,
            'payload' => null,
            'status' => LeadStatus::New,
            'ip' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }

    public function fromLanding(Landing $landing): self
    {
        return $this->state([
            'landing_id' => $landing->id,
            'source_url' => url('/'.$landing->slug),
        ]);
    }

    public function ofStatus(LeadStatus $status): self
    {
        return $this->state(['status' => $status]);
    }
}
