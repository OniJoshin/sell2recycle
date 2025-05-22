@props(['device'])

@php
    $brandSlug = Str::slug($device->brand ?? Str::before($device->name, ' '));
    $modelSlug = Str::slug($device->model ?? Str::after($device->name, ' '));
@endphp

<a href="{{ url("/compare/{$brandSlug}/{$modelSlug}") }}"
   class="block bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden text-center p-4">
    <img src="{{ $device->image_url ?? asset('images/placeholder-device.png') }}"
         alt="{{ $device->name }}" class="w-full h-36 object-contain mb-3">
    <h3 class="text-md font-semibold text-gray-900">{{ $device->name }}</h3>

    @if ($device->max_price)
        <p class="text-sm text-gray-600 mt-1">
            Up to <span class="font-bold text-brand">£{{ number_format($device->max_price, 2) }}</span>
        </p>
    @endif
</a>
