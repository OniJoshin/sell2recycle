<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
         $brands = Device::pluck('brand')
            ->map(function ($brand) {
                return Str::before($brand, ' ');
            })
            ->unique()
            ->sort()
            ->values();
        $popularDevices = Device::with('offers')
            ->withMax('offers', 'price')
            ->take(8)
            ->get()
            ->map(function ($device) {
                $device->brand = Str::before($device->name, ' ');
                $device->model = Str::after($device->name, ' ');
                $device->max_price = $device->offers_max_price;
                return $device;
            });


        return view('home', compact('brands', 'popularDevices'));
    }
}
