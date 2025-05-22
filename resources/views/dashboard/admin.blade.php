<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12 space-y-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Devices</h3>
                <p class="text-3xl">{{ $stats['devices'] }}</p>
                <a href="{{ route('admin.devices.index') }}" class="text-blue-600 text-sm">Manage Devices</a>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Vendors</h3>
                <p class="text-3xl">{{ $stats['vendors'] }}</p>
                <a href="{{ route('admin.vendors.index') }}" class="text-blue-600 text-sm">View Vendors</a>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Offers</h3>
                <p class="text-3xl">{{ $stats['offers'] }}</p>
                <a href="#" class="text-blue-600 text-sm">Offers (future global list)</a>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Aliases</h3>
                <p class="text-3xl">{{ $stats['aliases'] }}</p>
                <a href="{{ route('admin.aliases.index') }}" class="text-blue-600 text-sm">Manage Aliases</a>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Unmatched Feed Rows</h3>
                <p class="text-3xl">{{ $stats['unmatched'] }}</p>
                <a href="{{ route('admin.vendors.index') }}" class="text-blue-600 text-sm">Resolve via Vendors</a>
            </div>
        </div>
    </div>
</x-app-layout>
