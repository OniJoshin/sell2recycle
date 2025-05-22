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

    public function create()
    {
        return view('admin.devices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'storage' => 'required|string|max:255',
            'condition' => 'required|in:new,good,poor,broken',
        ]);

        Device::create($validated);

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
            'storage' => 'required|string|max:255',
            'condition' => 'required|in:new,good,poor,broken',
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
