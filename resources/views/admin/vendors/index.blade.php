<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Vendors</h2>
    </x-slot>

    <div class="p-6">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Feed URL</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $vendor)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $vendor->name }}</td>
                    <td class="px-4 py-2">{{ $vendor->email }}</td>
                    <td class="px-4 py-2 text-sm">{{ $vendor->feed_url }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.vendors.offers', $vendor) }}" class="text-blue-600">View Offers</a>
                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="text-blue-600">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
