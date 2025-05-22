<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Unmatched Products – {{ $vendor->name }}</h2>
    </x-slot>

    <div class="p-6">
        @if (count($rows))
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Network</th>
                        <th class="px-4 py-2 text-left">Condition</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $row[0] ?? '' }}</td>
                            <td class="px-4 py-2">{{ $row[1] ?? '' }}</td>
                            <td class="px-4 py-2">{{ $row[2] ?? '' }}</td>
                            <td class="px-4 py-2">{{ $row[3] ?? '' }}</td><td class="px-4 py-2 text-right">
                                <a href="{{ route('admin.aliases.create', ['prefill' => $row[0] ?? '']) }}" class="text-blue-600 text-sm">
                                    ➕ Create Alias
                                </a>
                                <a href="{{ route('admin.devices.create', ['prefill' => $row[0] ?? '', 'vendor_id' => $vendor->id]) }}" class="text-green-600 text-sm ml-2">
                                        ➕ Create Device
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No unmatched rows found.</p>
        @endif
    </div>
</x-app-layout>
