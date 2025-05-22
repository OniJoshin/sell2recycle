<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Add New Device</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.devices.store') }}" class="space-y-4">
            @csrf
            <div>
                <label>Brand</label>
                <input type="text" name="brand" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label>Model</label>
                <input type="text" name="model" value="{{ old('model', $prefill) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Storage</label>
                <input type="text" name="storage" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Device</button>
        </form>
    </div>
</x-app-layout>