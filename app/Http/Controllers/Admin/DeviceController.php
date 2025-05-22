<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('admin.devices.index', compact('devices'));
    }

    public function create(Request $request)
    {
        $prefill = $request->query('prefill', '');
        $vendorId = $request->query('vendor_id');

        return view('admin.devices.create', compact('prefill', 'vendorId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'storage' => 'nullable|string|max:255',
        ]);

        Device::create($validated);

        // Optional alias auto-linking
        if ($request->has('prefill') && $request->prefill && $request->vendor_id) {
            \App\Models\DeviceAlias::create([
                'alias' => $request->prefill,
                'device_id' => $device->id,
            ]);
            activity()
                ->performedOn($device)
                ->causedBy(auth()->user())
                ->log("Auto-created alias '{$request->prefill}'");

            $filePath = storage_path("app/vendor_feeds/unmatched_{$request->vendor_id}.csv");

            if (file_exists($filePath)) {
                $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $filtered = array_filter($lines, fn($line) => !str_contains(strtolower($line), strtolower($request->prefill)));
                file_put_contents($filePath, implode(PHP_EOL, $filtered) . PHP_EOL);
            }
            activity()
                ->performedOn($device)
                ->causedBy(auth()->user())
                ->log("Created device '{$device->brand} {$device->model} {$device->storage}' from unmatched row");
        }


        return redirect()->route('admin.devices.index')->with('success', 'Device created.');
    }

    public function edit(Device $device)
    {
        return view('admin.devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'storage' => 'nullable|string|max:255',
        ]);

        $device->update($validated);

        return redirect()->route('admin.devices.index')->with('success', 'Device updated.');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('admin.devices.index')->with('success', 'Device deleted.');
    }
}
