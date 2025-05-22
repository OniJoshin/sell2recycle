<nav x-data="{ open: false }" class="bg-white border-b border-brand text-accent-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <x-application-logo class="h-9 w-auto" />
                    <span class="font-bold text-lg text-brand hidden sm:inline">Sell2Recycle</span>
                </a>

                <div class="hidden sm:flex space-x-8 ms-10 items-center text-sm font-medium">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                    <x-nav-link :href="url('/search')" :active="request()->is('search')">Search</x-nav-link>
                    <x-nav-link :href="url('/guides')" :active="request()->is('guides*')">Guides</x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm text-gray-700">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            {{-- Hamburger --}}
            <div class="sm:hidden flex items-center -me-2">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke="currentColor" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke="currentColor" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')">Home</x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/search')">Search</x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/guides')">Guides</x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>
