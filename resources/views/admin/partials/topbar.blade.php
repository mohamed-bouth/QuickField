<header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-100 flex h-16 w-full items-center justify-between px-4 sm:px-6">
    <div class="flex items-center gap-4 flex-1">
        <button class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-50">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden sm:flex relative w-full max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
                type="text"
                placeholder="Search bookings, users, or fields..."
                class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-green-500 focus:ring-green-500 rounded-xl pl-10 pr-4 py-2 outline-none"
            >
        </div>
    </div>

    <div class="flex items-center gap-3 sm:gap-4">

        <button class="flex items-center gap-2 pl-2">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-sm font-semibold text-green-700 border border-green-200">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="hidden sm:flex flex-col items-start mr-1">
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                <span class="text-xs text-gray-500">{{ auth()->user()->email }}</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
            </svg>
        </button>
    </div>
</header>