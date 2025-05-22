<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Apple' => ['iPhone 13', 'iPhone 13 Pro', 'iPhone 12', 'iPhone 11'],
            'Samsung' => ['Galaxy S22', 'Galaxy S21', 'Note 20'],
            'Google' => ['Pixel 6', 'Pixel 7', 'Pixel 7 Pro']
        ];

        $storages = ['64GB', '128GB', '256GB', '512GB'];

        foreach ($brands as $brand => $models) {
            foreach ($models as $model) {
                foreach ($storages as $storage) {
                    Device::create([
                        'brand' => $brand,
                        'model' => $model,
                        'storage' => $storage,
                    ]);
                }
            }
        }
    }
}

