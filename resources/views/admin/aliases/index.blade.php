<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Device Aliases</h2>
    </x-slot>

    <div class="p-6 space-y-4">
        <a href="{{ route('admin.aliases.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            ➕ Add Alias
        </a>

        <table class="min-w-full bg-white shadow rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Alias</th>
                    <th class="px-4 py-2 text-left">Linked Device</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aliases as $alias)
                    <tr class="border-t">
                        <td class="px-4 py-2 font-mono text-sm">{{ $alias->alias }}</td>
                        <td class="px-4 py-2">
                            {{ $alias->device->brand }} {{ $alias->device->model }} {{ $alias->device->storage }}
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.aliases.edit', $alias) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.aliases.destroy', $alias) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete this alias?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-2 text-gray-500">No aliases found.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $aliases->links() }}
    </div>
</x-app-layout>
