<div x-data="{ profileOpen: false, notificationOpen: false, notificationCount: 3 }" class="bg-white shadow-sm border-b border-gray-200 px-6 py-2 fixed top-0 right-0 left-0 z-40"
    :class="$store.sidebar?.open ? 'ml-64' : 'ml-20'">
    <div class="flex items-center justify-between">
        <!-- LEFT: Title -->
        <div></div>

        <!-- RIGHT: Notification & User Profile -->
        <div class="flex items-center space-x-4">
            <!-- Notification Bell -->
            <div class="relative">
                <button @click="notificationOpen = !notificationOpen"
                    class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <!-- Notification Badge -->
                    <span x-show="notificationCount > 0"
                        class="absolute top-1 right-1 w-5 h-5 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center"
                        x-text="notificationCount"></span>
                </button>

                <!-- Notification Dropdown -->
                <div x-show="notificationOpen" @click.away="notificationOpen = false"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 py-2 max-h-96 overflow-y-auto">

                    <!-- Notification Header -->
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">Notifikasi</h3>
                        <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full"
                            x-text="notificationCount + ' baru'"></span>
                    </div>

                    <!-- View All Button -->
                    <div class="px-4 py-3 border-t border-gray-100">
                        <a href="#"
                            class="block text-center text-sm font-medium text-yellow-600 hover:text-yellow-700">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                </div>
            </div>
            <!-- User Profile Dropdown -->
            <div class="relative">
                <button @click="profileOpen = !profileOpen"
                    class="flex items-center space-x-3 hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors">
                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="profileOpen" @click.away="profileOpen = false"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2">

                    <!-- User Info -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->role }}</p>
                    </div>

                    <!-- Sign Out Button -->
                    <div class="px-2 py-2">
                        <a href="/logout"
                            class="flex items-center justify-center gap-2 w-full px-3 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-md transition-colors">

                            <!-- Icon Logout -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3" />
                            </svg>

                            Sign Out
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Spacer for fixed topbar -->
<div class="h-16"></div>
