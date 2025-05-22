<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Offers for {{ $vendor->name }}
            </h2>

            @if($unmatchedCount > 0)
                <a href="{{ route('admin.vendors.unmatched', $vendor) }}"
                class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded text-sm hover:bg-orange-200">
                    View Unmatched Products ({{ $unmatchedCount }})
                </a>
            @endif
        </div>
    </x-slot>


    <div class="p-6">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Device</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">Network</th>
                    <th class="px-4 py-2 text-left">Valid Until</th>
                    <th>Match Method</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $offer->device->brand }} {{ $offer->device->model }} {{ $offer->device->storage }}</td>
                    <td class="px-4 py-2">£{{ number_format($offer->price, 2) }}</td>
                    <td class="px-4 py-2">{{ $offer->network }}</td>
                    <td class="px-4 py-2">{{ $offer->valid_until?->format('Y-m-d') ?? 'N/A' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-500">{{ ucfirst($offer->match_method) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
