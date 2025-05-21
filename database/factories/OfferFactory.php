<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vendor;

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
            'vendor_id' => Vendor::factory(),
            'device_name' => $this->faker->randomElement([
                'iPhone 13 Pro Max', 'Samsung Galaxy S21', 'Google Pixel 7'
            ]),
            'storage' => $this->faker->randomElement(['64GB', '128GB', '256GB']),
            'condition' => $this->faker->randomElement(['new', 'good', 'poor', 'broken']),
            'network' => $this->faker->randomElement(['unlocked', 'ee', 'o2', 'vodafone']),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'valid_until' => now()->addDays(7),
        ];
    }
}
