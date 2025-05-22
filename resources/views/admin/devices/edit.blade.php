<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Edit Device</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.devices.update', $device) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label>Brand</label>
                <input type="text" name="brand" value="{{ $device->brand }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label>Model</label>
                <input type="text" name="model" value="{{ $device->model }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label>Storage</label>
                <input type="text" name="storage" value="{{ $device->storage }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label>Condition</label>
                <select name="condition" class="w-full border rounded px-3 py-2" required>
                    @foreach(['new', 'good', 'poor', 'broken'] as $condition)
                        <option value="{{ $condition }}" @selected($device->condition === $condition)>
                            {{ ucfirst($condition) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Device</button>
        </form>
    </div>
</x-app-layout>