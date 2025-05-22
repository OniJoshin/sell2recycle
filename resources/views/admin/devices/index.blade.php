<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Devices</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('admin.devices.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Device</a>

        <table class="min-w-full bg-white shadow rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Brand</th>
                    <th class="px-4 py-2 text-left">Model</th>
                    <th class="px-4 py-2 text-left">Storage</th>
                    <th class="px-4 py-2 text-left">Condition</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $device->brand }}</td>
                    <td class="px-4 py-2">{{ $device->model }}</td>
                    <td class="px-4 py-2">{{ $device->storage }}</td>
                    <td class="px-4 py-2">{{ ucfirst($device->condition) }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.devices.edit', $device) }}" class="text-blue-600">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>