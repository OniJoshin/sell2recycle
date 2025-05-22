<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Add Device Alias</h2>
    </x-slot>

    <x-alert />

    <div class="p-6">
        <form method="POST" action="{{ route('admin.aliases.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Alias</label>
                <input type="text" name="alias" value="{{ old('alias', $prefill ?? '') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold">Map to Device</label>
                <select name="device_id" class="w-full border rounded px-3 py-2">
                    @foreach ($devices as $device)
                        <option value="{{ $device->id }}">
                            {{ $device->brand }} {{ $device->model }} {{ $device->storage }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Alias</button>
        </form>
    </div>
</x-app-layout>
