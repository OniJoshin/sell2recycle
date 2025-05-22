@php use Illuminate\Support\Str; @endphp

<x-app-layout>
    <x-slot name="title">Sell Your Phone | Compare Prices</x-slot>
    <x-slot name="metaDescription">Get instant trade-in quotes from UK recyclers. No hidden fees.</x-slot>
    <x-slot name="canonical">{{ url()->current() }}</x-slot>

    {{-- HERO --}}
    <section class="text-center py-16 bg-brand-light">
        <div class="max-w-3xl mx-auto px-4">
            <h1 class="text-5xl font-extrabold text-accent-dark">Unlock the value of your old phone</h1>
            <p class="mt-4 text-lg text-accent-dark">
                Compare trade-in offers and get paid fast — free shipping, secure payments, great prices.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <x-search-box />
                <a href="{{ url('/search') }}"
                   class="px-8 py-3 bg-brand text-white rounded-xl shadow hover:bg-brand-dark transition text-lg font-medium">
                    Compare Prices
                </a>
            </div>
        </div>
    </section>

    {{-- POPULAR DEVICES --}}
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-semibold text-center mb-6">Most Popular Devices</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                @foreach ($popularDevices as $device)
                    <x-device-card :device="$device" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- POPULAR BRANDS --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-semibold mb-6">Popular Brands</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                @foreach ($brands as $brand)
                    <a href="{{ url('/brands/' . Str::slug($brand)) }}"
                       class="bg-white shadow p-4 rounded-xl hover:shadow-md transition text-xl font-semibold text-accent-dark">
                        {{ $brand }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- VALUE PROP --}}
    <section class="py-12 bg-white">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-2xl font-bold mb-4">Why Sell with Us?</h2>
            <p class="text-accent-dark leading-relaxed">
                We compare offers from top UK recycling merchants every 10–15 minutes. That means you always get the best payout, free shipping, and secure payments.
            </p>
            <a href="#how-it-works" class="mt-4 inline-block text-brand font-medium hover:underline">
                Learn How It Works
            </a>
        </div>
    </section>

    {{-- REUSABLE PARTIALS --}}
    @include('partials.how-it-works')
    @include('partials.featured-guides')
</x-app-layout>
