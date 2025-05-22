<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Vendor;
use App\Models\Offer;
use App\Models\DeviceAlias;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'devices' => Device::count(),
            'vendors' => Vendor::count(),
            'offers' => Offer::count(),
            'aliases' => DeviceAlias::count(),
            'unmatched' => $this->countUnmatchedRows(),
        ];

        return view('dashboard.admin', compact('stats'));
    }

    protected function countUnmatchedRows(): int
    {
        $total = 0;

        foreach (glob(storage_path('app/vendor_feeds/unmatched_*.csv')) as $file) {
            $total += count(file($file, FILE_SKIP_EMPTY_LINES));
        }

        return $total;
    }

}
