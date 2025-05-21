<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Recycle',
            'email' => $this->faker->companyEmail,
            'feed_url' => $this->faker->url,
            'api_key' => Str::random(32),
            'payment_info' => json_encode([
                'method' => $this->faker->randomElement(['bacs', 'paypal']),
                'sort_code' => $this->faker->numerify('##-##-##'),
                'account_number' => $this->faker->numerify('########'),
            ]),
        ];
    }
}
