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
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'feed_url' => 'nullable|url',
            'api_key' => 'nullable|string|max:255',
            'payment_info' => 'nullable|array',
        ]);

        // Save as JSON if payment_info is entered via grouped fields
        if ($request->has('payment_method')) {
            $data['payment_info'] = [
                'method' => $request->payment_method,
                'sort_code' => $request->sort_code,
                'account_number' => $request->account_number,
                'paypal' => $request->paypal,
            ];
        }

        $vendor->update($data);

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

        return view('admin.vendors.offers', compact('vendor', 'offers'));
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
