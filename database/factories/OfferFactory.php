<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vendor;
use App\Models\Device;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => Vendor::inRandomOrder()->first()?->id,
            'device_id' => Device::inRandomOrder()->first()?->id,
            'network' => $this->faker->randomElement(['unlocked', 'ee', 'o2', 'vodafone']),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'condition' => $this->faker->randomElement(['new', 'good', 'poor', 'broken']),
            'valid_until' => $this->faker->dateTimeBetween('now', '+1 year')
        ];
    }
}
