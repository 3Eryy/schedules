{{-- Sidebar Component --}}
<div x-data="{ open: true }" class="relative">
    {{-- Sidebar --}}
    <aside :class="open ? 'w-64' : 'w-20'" 
           class="fixed top-0 left-0 h-screen bg-white text-gray-800 transition-all duration-300 ease-in-out z-40 flex flex-col border-r border-gray-200">
        
        {{-- Header dengan Toggle Button --}}
        <div class="flex items-center justify-between p-4">
            <h1 x-show="open" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="text-lg font-semibold">
                Absensi Siwa
            </h1>
            <button @click="open = !open" 
                    class="p-2 rounded-md hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"/>
                </svg>
            </button>
        </div>

        {{-- Menu Items --}}
        <nav class="flex-1 overflow-y-auto py-4">
            {{-- Dashboard --}}
            <a href="/user/dashboard" 
               class="flex items-center px-4 py-3 mb-1 hover:bg-gray-50 transition-colors {{ request()->routeIs('dashboard') ? 'bg-yellow-50 text-yellow-700 border-r-2 border-yellow-500' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span x-show="open" 
                      x-transition:enter="transition ease-out duration-300 delay-100"
                      x-transition:enter-start="opacity-0 transform translate-x-2"
                      x-transition:enter-end="opacity-100 transform translate-x-0"
                      class="ml-3 font-medium text-sm">
                    Dashboard
                </span>
            </a>

            {{-- Riwayat Pengisian Jurnal --}}
            <a href="#" 
               class="flex items-center px-4 py-3 mb-1 hover:bg-gray-50 transition-colors {{ request()->routeIs('jurnal.*') ? 'bg-yellow-50 text-yellow-700 border-r-2 border-yellow-500' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span x-show="open" 
                      x-transition:enter="transition ease-out duration-300 delay-100"
                      x-transition:enter-start="opacity-0 transform translate-x-2"
                      x-transition:enter-end="opacity-100 transform translate-x-0"
                      class="ml-3 font-medium text-sm">
                    Riwayat Pengisian Jurnal
                </span>
            </a>

            {{-- Riwayat Pengisian Absensi --}}
            <a href="#" 
               class="flex items-center px-4 py-3 mb-1 hover:bg-gray-50 transition-colors {{ request()->routeIs('absensi.*') ? 'bg-yellow-50 text-yellow-700 border-r-2 border-yellow-500' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span x-show="open" 
                      x-transition:enter="transition ease-out duration-300 delay-100"
                      x-transition:enter-start="opacity-0 transform translate-x-2"
                      x-transition:enter-end="opacity-100 transform translate-x-0"
                      class="ml-3 font-medium text-sm">
                    Riwayat Pengisian Absensi
                </span>
            </a>

            {{-- Jadwal Mengajar --}}
            <a href="#" 
               class="flex items-center px-4 py-3 mb-1 hover:bg-gray-50 transition-colors {{ request()->routeIs('jadwal.*') ? 'bg-yellow-50 text-yellow-700 border-r-2 border-yellow-500' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span x-show="open" 
                      x-transition:enter="transition ease-out duration-300 delay-100"
                      x-transition:enter-start="opacity-0 transform translate-x-2"
                      x-transition:enter-end="opacity-100 transform translate-x-0"
                      class="ml-3 font-medium text-sm">
                    Jadwal Mengajar
                </span>
            </a>
        </nav>

        {{-- Pengaturan (Bottom) --}}
        <div class="border-t border-gray-200 p-4">
            <a href="#" 
               class="flex items-center px-4 py-3 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('pengaturan') ? 'bg-yellow-50 text-yellow-700 border-r-2 border-yellow-500' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-show="open" 
                      x-transition:enter="transition ease-out duration-300 delay-100"
                      x-transition:enter-start="opacity-0 transform translate-x-2"
                      x-transition:enter-end="opacity-100 transform translate-x-0"
                      class="ml-3 font-medium text-sm">
                    Pengaturan
                </span>
            </a>
        </div>
    </aside>
    <!-- PAGE CONTENT -->
    <div :class="open ? 'ml-64' : 'ml-20'" class="transition-all duration-300 min-h-screen bg-gray-50">
        {{ $slot }}
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>