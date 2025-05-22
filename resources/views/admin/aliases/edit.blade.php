<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Edit Alias</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.aliases.update', $alias) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block font-semibold">Alias</label>
                <input type="text" name="alias" value="{{ $alias->alias }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold">Mapped Device</label>
                <select name="device_id" class="w-full border rounded px-3 py-2">
                    @foreach ($devices as $device)
                        <option value="{{ $device->id }}" @selected($device->id === $alias->device_id)>
                            {{ $device->brand }} {{ $device->model }} {{ $device->storage }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Alias</button>
        </form>
    </div>
</x-app-layout>
