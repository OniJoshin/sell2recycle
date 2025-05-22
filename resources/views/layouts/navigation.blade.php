<nav x-data="{ open: false }" class="bg-gray-100 border-b border-brand text-accent-dark relative z-50">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <x-application-logo class="h-9 w-auto" />
                <span class="font-bold text-lg text-brand hidden sm:inline">Sell2Recycle</span>
            </a>
        </div>

        <!-- Always Visible Hamburger -->
        <button @click="open = true"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Slide-out Menu (Right Side) -->
    <div x-show="open"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        x-cloak
        class="fixed inset-y-0 right-0 w-64 bg-white shadow-xl z-50 p-6">
        
        <button @click="open = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <a href="{{ route('home') }}" class="block mt-6 text-lg font-medium text-accent-dark hover:text-brand">Home</a>
        <a href="{{ url('/search') }}" class="block mt-4 text-lg font-medium text-accent-dark hover:text-brand">Search</a>
        <a href="{{ url('/guides') }}" class="block mt-4 text-lg font-medium text-accent-dark hover:text-brand">Guides</a>
        
        @auth
            <a href="{{ route('dashboard') }}" class="block mt-4 text-lg font-medium text-accent-dark hover:text-brand">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="block mt-4 text-lg font-medium text-accent-dark hover:text-brand">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="text-lg font-medium text-accent-dark hover:text-brand">Log Out</button>
            </form>
        @endauth
    </div>


    <!-- Optional: Page overlay -->
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-30 z-40" @click="open = false" x-cloak></div>
</nav>
