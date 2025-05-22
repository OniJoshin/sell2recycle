<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Jobs\ParseVendorFeed;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function edit(Vendor $vendor)
    {
        $vendor->payment_info = is_array($vendor->payment_info)
            ? $vendor->payment_info
            : json_decode($vendor->payment_info ?? '{}', true);

        $feedLogs = $vendor->feedLogs()->latest()->take(5)->get();


        return view('admin.vendors.edit', compact('vendor', 'feedLogs'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'feed_url' => 'nullable|url',
            'api_key' => 'nullable|string|max:255',
        ]);

        $data['payment_info'] = [
            'methods' => $request->payment_methods ?? [],
            'payout_speed' => $request->payout_speed,
        ];

        $vendor->update($data);
        activity()
            ->performedOn($vendor)
            ->causedBy(auth()->user())
            ->log("Updated vendor '{$vendor->name}'");

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully.');
    }


    public function refreshFeed(Vendor $vendor)
    {
        ParseVendorFeed::dispatch($vendor);

        activity()->performedOn($vendor)->causedBy(auth()->user())
            ->log("Admin dispatched feed refresh.");

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Feed refresh queued for ' . $vendor->name);
    }

    public function showOffers(Vendor $vendor)
    {
        $offers = $vendor->offers()->with('device')->get();
        $unmatchedFile = storage_path("app/vendor_feeds/unmatched_{$vendor->id}.csv");
        $unmatchedCount = file_exists($unmatchedFile)
            ? count(file($unmatchedFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))
            : 0;
        return view('admin.vendors.offers', compact('vendor', 'offers', 'unmatchedCount'));
    }

    public function viewUnmatchedRows(Vendor $vendor)
    {
        $file = storage_path("app/vendor_feeds/unmatched_{$vendor->id}.csv");

        $rows = [];

        if (file_exists($file)) {
            $rows = array_map('str_getcsv', file($file));
        }

        return view('admin.vendors.unmatched', compact('vendor', 'rows'));
    }



}
