<nav class="bg-teal-700 text-white">
    <div class="container mx-auto px-4 flex items-center justify-between h-14">
        <!-- Logo -->
        <a href="/" class="flex items-center">
            <img src="https://ppicis.peoplenpartners.net/logo-long-white.png" alt="IT Ticket System" class="h-10" />
        </a>

        <!-- Mobile menu button -->
        <div x-data="{ open: false }" class="lg:hidden">
            <button @click="open = !open"
                    class="focus:outline-none focus:ring-2 focus:ring-white p-2 rounded"
                    aria-label="Toggle menu">
                <svg :class="{'hidden': open, 'block': !open }" class="h-6 w-6" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg :class="{'block': open, 'hidden': !open }" class="h-6 w-6" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex lg:items-center lg:space-x-6">
            <a href="{{ route('support-requests.index') }}" class="hover:underline">Home</a>
            <a href="{{ route('support-requests.create') }}" class="hover:underline">Create New Request</a>
            <a href="{{ route('support-requests.myrequest') }}" class="hover:underline">View Your Ticket</a>

            @auth
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center space-x-1 focus:outline-none focus:ring-2 focus:ring-white">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                         x-transition
                         class="absolute right-0 mt-2 w-40 bg-white text-gray-900 rounded shadow-lg z-20">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-data="{ open: false }" class="lg:hidden" x-show="open" @click.away="open = false" x-cloak>
        <div class="px-4 pt-2 pb-4 space-y-1 bg-teal-700">
            <a href="/" class="block py-2 text-white hover:underline">Home</a>
            <a href="/about" class="block py-2 text-white hover:underline">About</a>

            @auth
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                            class="w-full text-left flex justify-between items-center py-2 text-white focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                         x-transition
                         class="mt-1 bg-white text-gray-900 rounded shadow-lg">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-white hover:underline">Login</a>
            @endauth
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</nav>
