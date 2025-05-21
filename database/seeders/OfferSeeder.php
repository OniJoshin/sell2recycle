<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::all()->each(function ($vendor) {
            Offer::factory()->count(10)->create([
                'vendor_id' => $vendor->id,
            ]);
        });
    }
}
