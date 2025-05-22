<?php

namespace Database\Seeders;

use App\Models\DeviceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeviceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeviceCategory::insert([
            ['slug' => 'phone', 'label' => 'Phones'],
            ['slug' => 'tablet', 'label' => 'Tablets'],
            ['slug' => 'console', 'label' => 'Consoles'],
        ]);
    }
}
