<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Edit Vendor</h2>
    </x-slot>

    <x-alert />

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
                    <label>Payment Method</label>
                    <select name="payment_method" class="w-full border rounded px-3 py-2">
                        <option value="">--</option>
                        <option value="bacs">BACS</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <div>
                    <label>Sort Code</label>
                    <input name="sort_code" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label>Account Number</label>
                    <input name="account_number" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label>PayPal Email</label>
                    <input name="paypal" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Vendor</button>
        </form>
    </div>
</x-app-layout>
