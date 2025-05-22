<form action="{{ route('search') }}" method="GET" class="mt-6 max-w-xl mx-auto">
    <div class="flex rounded-full shadow overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-brand">
        <input type="text" name="q" placeholder="Search your phone model..."
               class="w-full px-5 py-3 text-sm focus:outline-none"
               autocomplete="off" />
        <button type="submit"
                class="bg-brand text-white px-6 font-medium hover:bg-brand-dark transition">
            Search
        </button>
    </div>
</form>
