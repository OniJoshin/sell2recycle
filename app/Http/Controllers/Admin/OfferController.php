<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        $devices = \App\Models\Device::orderBy('brand')->get();
        return view('admin.offers.edit', compact('offer', 'devices'));
    }

    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'price' => 'required|numeric|min:1',
        ]);

        $offer->update([
            'device_id' => $validated['device_id'],
            'price' => $validated['price'],
            'match_method' => 'manual',
        ]);

        return redirect()->route('admin.offers.index')->with('success', 'Offer updated with manual match.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
