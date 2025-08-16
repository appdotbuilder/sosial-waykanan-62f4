<nav class="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 z-50 dark:bg-gray-900/95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">DS</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Dinas Sosial</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Kabupaten Way Kanan</p>
                    </div>
                </a>
            </div>
            
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Authenticated Navigation -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" 
                           class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors dark:text-gray-300 {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}">
                            Dashboard
                        </a>
                        
                        <a href="{{ route('applications.index') }}" 
                           class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors dark:text-gray-300 {{ request()->routeIs('applications.*') ? 'text-blue-600' : '' }}">
                            Pengajuan
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors dark:text-gray-300">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 dark:bg-gray-800"
                                 style="display: none;">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest Navigation -->
                    <div class="flex space-x-3">
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors dark:text-gray-300">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>