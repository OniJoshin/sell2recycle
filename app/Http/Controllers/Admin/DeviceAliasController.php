<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceAlias;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceAliasController extends Controller
{
    public function index()
    {
        $aliases = DeviceAlias::with('device')->latest()->paginate(25);
        return view('admin.aliases.index', compact('aliases'));
    }

    public function create()
    {
        $devices = \App\Models\Device::orderBy('brand')->get();
        $prefill = $request->query('prefill', '');

        return view('admin.aliases.create', compact('devices', 'prefill'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alias' => 'required|unique:device_aliases,alias',
            'device_id' => 'required|exists:devices,id',
        ]);

        DeviceAlias::create($request->only('alias', 'device_id'));

        $aliasValue = trim($request->alias);

        // Optional: attempt to find the vendor ID if this is alias cleanup
        // You can pass ?vendor_id=123 from the unmatched feed if needed

        foreach (glob(storage_path('app/vendor_feeds/unmatched_*.csv')) as $filePath) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $filtered = array_filter($lines, function ($line) use ($aliasValue) {
                return !str_contains(strtolower($line), strtolower($aliasValue));
            });

            // Overwrite the unmatched file with filtered lines
            file_put_contents($filePath, implode(PHP_EOL, $filtered) . PHP_EOL);
        }


        return redirect()->route('admin.aliases.index')->with('success', 'Alias added.');
    }

    public function edit(DeviceAlias $alias)
    {
        $devices = Device::orderBy('brand')->get();
        return view('admin.aliases.edit', compact('alias', 'devices'));
    }

    public function update(Request $request, DeviceAlias $alias)
    {
        $request->validate([
            'alias' => 'required|unique:device_aliases,alias,' . $alias->id,
            'device_id' => 'required|exists:devices,id',
        ]);

        $alias->update($request->only('alias', 'device_id'));

        return redirect()->route('admin.aliases.index')->with('success', 'Alias updated.');
    }

    public function destroy(DeviceAlias $alias)
    {
        $alias->delete();
        return redirect()->route('admin.aliases.index')->with('success', 'Alias removed.');
    }
}
