<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Edit Offer - {{ $offer->vendor->name }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="p-6 space-y-6">
        <form method="POST" action="{{ route('admin.offers.update', $offer) }}">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1">Device</label>
                <select name="device_id" class="w-full border px-3 py-2 rounded">
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}" @selected($offer->device_id === $device->id)>
                            {{ $device->brand }} {{ $device->model }} {{ $device->storage }} ({{ $device->condition }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Network</label>
                <input type="text" name="network" value="{{ $offer->network }}" class="w-full border px-3 py-2 rounded" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Price (£)</label>
                <input type="number" step="0.01" name="price" value="{{ $offer->price }}" class="w-full border px-3 py-2 rounded" />
            </div>

            <div>
                <label class="block font-semibold mb-1 text-gray-600">Match Method</label>
                <input type="text" value="{{ ucfirst($offer->match_method) }}" disabled class="w-full border px-3 py-2 rounded bg-gray-100 text-gray-500" />
                <p class="text-xs mt-1 text-gray-500">This will be updated to <strong>manual</strong> upon saving.</p>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Offer</button>
            </div>
        </form>
    </div>
</x-app-layout>
