<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Edit Vendor</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.vendors.refreshFeed', $vendor) }}">
            @csrf
            <button class="mb-4 bg-orange-500 text-white px-4 py-2 rounded">
                🔄 Refresh Feed
            </button>
        </form>

        <form method="POST" action="{{ route('admin.vendors.update', $vendor) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label>Name</label>
                <input name="name" value="{{ $vendor->name }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label>Email</label>
                <input name="email" value="{{ $vendor->email }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label>Feed URL</label>
                <input name="feed_url" value="{{ $vendor->feed_url }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label>API Key</label>
                <input name="api_key" value="{{ $vendor->api_key }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Accepted Payment Methods</label>
                    <label><input type="checkbox" name="payment_methods[]" value="bacs"
                        @checked(in_array('bacs', $vendor->payment_info['methods'] ?? []))> BACS</label><br>
                    <label><input type="checkbox" name="payment_methods[]" value="paypal"
                        @checked(in_array('paypal', $vendor->payment_info['methods'] ?? []))> PayPal</label>
                </div>
                <div class="mt-4">
                    <label class="block font-semibold mb-1">Payout Speed</label>
                    <select name="payout_speed" class="w-full border px-3 py-2 rounded">
                        @foreach(['same_day', 'next_day', 'within_3_days', 'weekly'] as $option)
                            <option value="{{ $option }}"
                                @selected(($vendor->payment_info['payout_speed'] ?? '') === $option)>
                                {{ ucfirst(str_replace('_', ' ', $option)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Vendor</button>
        </form>
    </div>
    <div class="p-6">
        @if ($feedLogs->count())
            <h3 class="text-lg font-semibold mb-2">Recent Feed Activity</h3>
            <table class="min-w-full bg-white text-sm rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Parsed</th>
                        <th class="px-4 py-2 text-left">Matched</th>
                        <th class="px-4 py-2 text-left">Unmatched</th>
                        <th class="px-4 py-2 text-left">Skipped</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedLogs as $log)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2">{{ $log->offers_total }}</td>
                            <td class="px-4 py-2">{{ $log->offers_matched }}</td>
                            <td class="px-4 py-2">{{ $log->offers_unmatched }}</td>
                            <td class="px-4 py-2">{{ $log->offers_skipped }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
